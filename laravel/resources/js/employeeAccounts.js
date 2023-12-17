$(function () {

    $(document).on('click', '#createEmployeeAccountButton', function() {
        $("#createEmployeeAccountModal").css("display", "flex");
    });
    
    $(document).on('click', '#closeCreateEmployeeAccountModal', function() {
        $("#createEmployeeAccountModal").hide();
    });
    
    $(document).on('click', '.editEmployeeAccountButton', function () {
        $(`#update-checkboxes-container input[type="checkbox"]`).prop('checked', false);
        var closestEditButton = $(this).closest('.editEmployeeAccountButton');
        var employeeId = closestEditButton.data('id');
        window.employeeIdForUpdate = employeeId;
        $('#editEmployeeAccountModal').css("display", "flex");
        $('.employeeAccountCrudModal').hide();
    
        axios.get(`/api/employee/${employeeId}`)
        .then(response => {
            let employee = response.data[0]
            $('#employees #employee-name').val(employee.name);
            $('#employees #employee-email').val(employee.email);
            $('#employees #employee-phone_number').val(employee.phone_number);
            $(`#employees #${employee.gender}`).prop('checked', true);

            if (employee.bookable_online) {
                $('#employee-bookable_online').prop('checked', true);
            }   
            console.log(employee.services)
            employee.services.forEach(service => {
                $(`#update-checkboxes-container input[value="${service.id}"]`).prop('checked', true);
            });

        })
        .catch(error => {
            console.error(error);
        });

    });  
    
    $(document).on('click', '#closeEditEmployeeAccountModal', function() {
        $("#editEmployeeAccountModal").hide();
    });
    
    $(document).on('click', '.employeeAccountCrudModalButton', function () {
        var index = $('.employeeAccountCrudModalButton').index(this);
        $('.employeeAccountCrudModal').eq(index).toggle();
    });

    $(document).on('click', '.deleteEmployeeAccountButton', function() {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Are you sure you want to delete this employee",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete employee'
        }).then((result) => {
            if (result.isConfirmed) {
                let employeeId = $(this).data('id');

                axios.delete(`/api/employees/${employeeId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your employee has been deleted.', 'success');
                        $(`#${employeeId}`).remove();
                    })
                    .catch(error => {
                        console.error('Error deleting employee:', error);
                        Swal.fire('Error', 'Could not delete the employee. Please try again.', 'error');
                    });
            }
        });
    });
    

    // Index
    function fetchEmployees() {
        axios.get('/api/employees')
            .then(response => {
                const employeesDiv = $('.employees-div');

                employeesDiv.empty();

                response.data.employees.forEach(employee => {
                    const initials = employee.name.charAt(0);
                    const employeeElement = `
                    <div class="employee">
                        <!-- Add your employee details here -->
                        <div class="identity">
                            <div class="profile-picture">
                                <div class="circle">
                                    <p>${initials}</p>
                                </div>
                            </div>
                            <p class="name">${employee.name}</p>
                        </div>
                        <div class="group">
                            <p>${employee.services.length} services</p>
                            <button class="employeeAccountCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                            <div class="crudModal employeeAccountCrudModal">
                                <button class="editEmployeeAccountButton" data-id="${employee.id}">
                                    <img src="${baseUrl}svg/pen.svg" alt="">
                                    Edit
                                </button>
                                <button class="deleteEmployeeAccountButton" data-id="${employee.id}">
                                    <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                    employeesDiv.append(employeeElement);
                });
            })
            .catch(error => {
                console.error('Error fetching employees:', error);
            });
    }

    fetchEmployees()

    $('#employees-type').on('change', function () {
        if ($(this).val() == 0) {
            fetchEmployees();
        } else if ($(this).val() == 1) {
            fetchBookableEmployees();
        } else if ($(this).val() == 2) {
            fetchArchivedEmployees();
        }
    });

    function fetchBookableEmployees() {
        axios.get('/api/employees')
            .then(function (response) {
                const employeesDiv = $('.employees-div');
                employeesDiv.empty();
                response.data.employees.forEach(employee => {
                    if(employee.bookable_online){
                        const initials = employee.name.charAt(0);
                        const employeeElement = `
                        <div class="employee">
                            <!-- Add your employee details here -->
                            <div class="identity">
                                <div class="profile-picture">
                                    <div class="circle">
                                        <p>${initials}</p>
                                    </div>
                                </div>
                                <p class="name">${employee.name}</p>
                            </div>
                            <div class="group">
                                <p>${employee.services.length} services</p>
                                <button class="employeeAccountCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                                <div class="crudModal employeeAccountCrudModal">
                                    <button class="editEmployeeAccountButton" data-id="${employee.id}">
                                        <img src="${baseUrl}svg/pen.svg" alt="">
                                        Edit
                                    </button>
                                    <button class="deleteEmployeeAccountButton" data-id="${employee.id}">
                                        <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                        employeesDiv.append(employeeElement);
                    }
                });

            })
            .catch(function (error) {
                console.error(error);
            });
    }
    
    function fetchArchivedEmployees() {
        axios.get('/api/employees/deleted')
            .then(function (response) {
                const employeesDiv = $('.employees-div');
                employeesDiv.empty();
                console.log(response.data.employees)
                response.data.employees.forEach(employee => {
                        const initials = employee.name.charAt(0);
                        const employeeElement = `
                        <div class="employee">
                            <!-- Add your employee details here -->
                            <div class="identity">
                                <div class="profile-picture">
                                    <div class="circle">
                                        <p>${initials}</p>
                                    </div>
                                </div>
                                <p class="name">${employee.name}</p>
                            </div>
                            <div class="group">
                                <p>${employee.services.length} services</p>
                                <button class="employeeAccountCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                                <div class="crudModal employeeAccountCrudModal">
                                    <button class="editEmployeeAccountButton" data-id="${employee.id}">
                                        <img src="${baseUrl}svg/pen.svg" alt="">
                                        Edit
                                    </button>
                                    <button class="deleteEmployeeAccountButton" data-id="${employee.id}">
                                        <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                        employeesDiv.append(employeeElement);
                    
                });
            })
            .catch(function (error) {
                console.error(error);
            });
    }

    $('#search_employees').on('keyup', function () {
        var searchQuery = $(this).val();
    
        if (searchQuery.trim() !== '') {
            fetchEmployeesBySearch(searchQuery);
        } else {
            fetchEmployees();
        }
    });
    
    function fetchEmployeesBySearch(query) {
        axios.get('/api/employees/search', {
            params: { query: query }
        })
        .then(function (response) {
            const employeesDiv = $('.employees-div');
            employeesDiv.empty();
            response.data.employees.forEach(employee => {
                console.log(employee.name)
                const initials = employee.name.charAt(0);
                const employeeElement = `
                    <div class="employee">
                        <!-- Add your employee details here -->
                        <div class="identity">
                            <div class="profile-picture">
                                <div class="circle">
                                    <p>${initials}</p>
                                </div>
                            </div>
                            <p class="name">${employee.name}</p>
                        </div>
                        <div class="group">
                            <p>${employee.services.length} services</p>
                            <button class="employeeAccountCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                            <div class="crudModal employeeAccountCrudModal">
                                <button class="editEmployeeAccountButton" data-id="${employee.id}">
                                    <img src="${baseUrl}svg/pen.svg" alt="">
                                    Edit
                                </button>
                                <button class="deleteEmployeeAccountButton" data-id="${employee.id}">
                                    <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                employeesDiv.append(employeeElement);
            });
        })
        .catch(function (error) {
            console.error(error);
        });
    }

    // Fetch service categories and services
    function populateCheckboxesContainer(containerId){
        axios.get('/api/employees/service-categories-with-services')
        .then(response => {
            const categoriesWithServices = response.data
            console.log(categoriesWithServices)
            // Handle the response to create checkboxes dynamically
            const checkboxesContainer = document.getElementById(containerId);
    
            categoriesWithServices.forEach(category => {
                // Create a label for the category
                const categoryLabel = document.createElement('label');
                categoryLabel.innerHTML = `<strong>${category.name}</strong>`;
                checkboxesContainer.appendChild(categoryLabel);
    
                // Create a container for services within the category
                const servicesContainer = document.createElement('div');
                servicesContainer.classList.add('services-container');
                checkboxesContainer.appendChild(servicesContainer);
    
                // Create checkboxes for services in the category
                category.services.forEach(service => {
                    const serviceCheckbox = document.createElement('input');
                    serviceCheckbox.type = 'checkbox';
                    serviceCheckbox.name = 'services[]';
                    serviceCheckbox.value = service.id;
                    serviceCheckbox.id = service.id;
    
                    const serviceLabel = document.createElement('label');
                    serviceLabel.innerHTML = service.name;
                    serviceLabel.htmlFor = service.id
    
                    const serviceContainer = document.createElement('div');
                    serviceContainer.classList.add('service');
                    serviceContainer.appendChild(serviceCheckbox);
                    serviceContainer.appendChild(serviceLabel);
    
                    servicesContainer.appendChild(serviceContainer);
                });
            });
        })
        .catch(error => {
            console.error(error);
        });
    }

    populateCheckboxesContainer('checkboxes-container')
    populateCheckboxesContainer('update-checkboxes-container')

    // Employee store
    $('#employee-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/employees/store', formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Employee created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('employee-store').reset();
                $('#createEmployeeAccountModal').css("display", "none");
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#employee-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Employee update
    $('#employee-update').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var employeeId = window.employeeIdForUpdate;

        axios.patch(`/api/employees/update/${employeeId}`, formData)
            .then(response => {
                $('.alert-success').text('Customer updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $("#editEmployeeAccountModal").css("display", "none");
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Employee delete



})