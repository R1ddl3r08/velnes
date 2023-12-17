$(function () {
    $("#createServiceButton").click(function() {
        $("#createServiceModal").css("display", "flex");
    });
  
    $("#closeCreateServiceModal").click(function() {
        $("#createServiceModal").hide();
    });

    $(".editServiceButton").click(function() {
        $("#editServiceModal").css("display", "flex");
        $('.serviceCrudModal').hide()
    });
  
    $("#closeEditServiceModal").click(function() {
        $("#editServiceModal").hide();
    });

    $('.serviceCrudModalButton').click(function () {
        var index = $('.serviceCrudModalButton').index(this);
    
        $('.serviceCrudModal').eq(index).toggle();
    });

    $(".deleteServiceButton").click(function() {
        // Use SweetAlert for the confirmation
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete service'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Deleted!', 'Service has been deleted', 'success');
            }
        });
    });

    // Index
    function fetchServices() {
        axios.get('/api/services')
            .then(response => {
                const servicesDiv = $('.services-div');
    
                servicesDiv.empty();
    
                response.data.serviceCategories.forEach(category => {
                    const categoryElement = $(`
                        <div class="service-category closed" data-category-id="${category.id}">
                            <div class="inner-service-category">
                                <h3>${category.name}</h3>
                                <div class="group">
                                    <p>${category.services.length} services</p>
                                    <button class="categoryServiceCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                                    <div class="crudModal categoryServiceCrudModal">
                                        <button class="editCategoryServiceButton" data-id="${category.id}">
                                            <img src="${baseUrl}svg/pen.svg" alt="">
                                            Edit
                                        </button>
                                        <button class="deleteCategoryServiceButton" data-id="${category.id}">
                                            <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                            Delete
                                        </button>
                                    </div>
                                    <img class="arrow-icon" src="${arrowDownIconUrl}">
                                </div>
                            </div>
                            <div class="services-list" style="display: none;"></div>
                        </div>
                    `);
    
                    category.services.forEach(service => {
                        const serviceElement = `
                            <div class="service" data-service-id="${service.id}">
                                <p>${service.name}</p>
                                <div class="group">
                                    <p class="duration">${service.duration} min</p>
                                    <p class="price">&euro;${service.price}</p>
                                    <button class="serviceCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                                    <div class="crudModal serviceCrudModal">
                                        <button class="editServiceButton" data-id="${service.id}">
                                            <img src="${baseUrl}svg/pen.svg" alt="">
                                            Edit
                                        </button>
                                        <button class="deleteServiceButton" data-id="${service.id}">
                                            <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                        categoryElement.find('.services-list').append(serviceElement);
                    });
    
                    servicesDiv.append(categoryElement);

                    let color = category.color;
                
                    categoryElement.find('.inner-service-category').css({
                        'background-color': blendWithWhite(color, 0.3),
                        'border': `1px solid ${color}`
                    });
                });
    
            })
            .catch(error => {
                console.error('Error fetching services:', error);
            });
    }
    $(document).on('click', '.service-category', function (event) {
        if (!$(event.target).hasClass('categoryServiceCrudModalButton') && !$(event.target).hasClass('serviceCrudModalButton') && !$(event.target).hasClass('serviceCrudModal') && !$(event.target).hasClass('categoryServiceCrudModal')) {
            const servicesList = $(this).find('.services-list');
            servicesList.slideToggle();
            servicesList.toggleClass('active');

            const toggleIcon = $(this).find('.arrow-icon');
            toggleIcon.attr('src', servicesList.hasClass('active') ? arrowUpIconUrl : arrowDownIconUrl);

        }
    });
    fetchServices();

    function blendWithWhite(hex, alpha) {
        hex = hex.replace(/^#/, '');
    
        const bigint = parseInt(hex, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;
    
        const blendedR = Math.round((1 - alpha) * 255 + alpha * r);
        const blendedG = Math.round((1 - alpha) * 255 + alpha * g);
        const blendedB = Math.round((1 - alpha) * 255 + alpha * b);
    
        const blendedHex = ((1 << 24) + (blendedR << 16) + (blendedG << 8) + blendedB).toString(16).slice(1);
    
        return `#${blendedHex}`;
    }

    $(document).on('click', '.categoryServiceCrudModalButton', function () {
        var index = $('.categoryServiceCrudModalButton').index(this);
        $('.categoryServiceCrudModal').eq(index).toggle();
    });

    $(document).on('click', '.serviceCrudModalButton', function () {
        var index = $('.serviceCrudModalButton').index(this);
        $('.serviceCrudModal').eq(index).toggle();
    });

    // Search services
    $('#search_services').keyup(function () {
        var searchQuery = $(this).val();

        if(searchQuery !== ''){
            $.ajax({
                url: '/api/services/search',
                type: 'GET',
                dataType: 'json',
                data: { search_query: searchQuery },
                success: function (data) {
                    updateServicesDiv(data.services);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            fetchServices()
        }

    });
    function updateServicesDiv(services)
    {
        $('.services-div').empty()
        $.each(services, function (index, service) {
            const serviceElement = `
            <div class="service" data-service-id="${service.id}">
                <p>${service.name}</p>
                <div class="group">
                <div class="service-details">
                    <p class="duration">${service.duration} min</p>
                    <p class="price">&euro;${service.price}</p>
                </div>
                    <button class="serviceCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                    <div class="crudModal serviceCrudModal">
                        <button class="editServiceButton" data-id="${service.id}">
                            <img src="${baseUrl}svg/pen.svg" alt="">
                            Edit
                        </button>
                        <button class="deleteServiceButton" data-id="${service.id}">
                            <img src="${baseUrl}svg/trash-grey.svg" alt="">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            `;

            $('.services-div').append(serviceElement)
        })
    }

    // Services filter
    function populateServicesSelect()
    {
        $.ajax({
            url: '/api/serviceCategories',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                let servicesSelect = $('#serviceCategoriesSelect')
                servicesSelect.empty();
                servicesSelect.html(`<option value="0">All categories</option>`)
                $.each(data, function (index, category) {
                    servicesSelect.append($('<option>', {
                        value: category.id,
                        text: category.name
                    }));
                });
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }

    populateServicesSelect()

    $('#serviceCategoriesSelect').change(function () {
        let categoryId = $(this).val()

        if(categoryId !== '0'){
            $.ajax({
                url: `/api/services/category/${categoryId}`,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    updateServicesDiv(data)
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            fetchServices()
        }
    })

    // service category store
    $('#addServiceCategoryButton').on('click', function (){
        $('#createServiceCategoryModal').css('display', 'flex')
    })

    $('#closeCreateServiceCategoryModal').on('click', function (){
        $('#createServiceCategoryModal').css('display', 'none')
    })

    $('#service-category-color').change(function () {
        let value = $(this).val()

        if (value !== '0'){
            $('.color-group .circle .inner-circle').css('background-color', `${value}`)
        } else {
            $('.color-group .cirlce .inner-circle').css('background-color', `white`)
        }
    })

    $('#store-service-category').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/serviceCategory', formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Service category created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('store-service-category').reset();
                $('#createServiceCategoryModal').css('display', 'none')
                fetchServices()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#service-category-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // service category update
    $('#update-service-category-color').change(function () {
        let value = $(this).val()

        if (value !== '0'){
            $('.color-group .circle .inner-circle').css('background-color', `${value}`)
        } else {
            $('.color-group .cirlce .inner-circle').css('background-color', `white`)
        }
    })

    $(document).on('click', '.editCategoryServiceButton', function() {
        $("#editServiceCategoryModal").css("display", "flex");
        $('.serviceCategoryCrudModal').hide();

        var serviceCategoryId = $(this).data('id');
        $('#update-service-category').attr('data-id', serviceCategoryId);

        axios.get(`/api/serviceCategory/${serviceCategoryId}`)
            .then(response => {
                $('#update-service-category-name').val(response.data.name);
                $('#update-service-category-color').val(response.data.color);
                $('.color-group .circle .inner-circle').css('background-color', `${response.data.color}`)
            })
            .catch(error => {
                console.error('Error fetching customer group details:', error);
            });

    });

    $(document).on('click', '#closeEditServiceCategoryModal', function() {
        $("#editServiceCategoryModal").css("display", "none");
    });

    $('#update-service-category').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        let serviceCategoryId = $(this).data('id')

        axios.patch(`/api/serviceCategory/${serviceCategoryId}`, formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Service category updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('update-service-category').reset();
                $('#editServiceCategoryModal').css('display', 'none')
                fetchServices()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-service-category-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // service category delete
    $(document).on('click', '.deleteCategoryServiceButton', function() {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete service category'
        }).then((result) => {
            if (result.isConfirmed) {
                let serviceCategoryId = $(this).data('id');

                axios.delete(`/api/serviceCategory/${serviceCategoryId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your service category has been deleted.', 'success');
                        fetchServices()
                    })
                    .catch(error => {
                        console.error('Error deleting service category:', error);
                        Swal.fire('Error', 'Could not delete the service category. Please try again.', 'error');
                    });
            }
        });
    })

    // service store
    $('#createServiceButton').on('click', function (){
        $('#createServiceModal').css('display', 'flex')
    })

    $('#closeCreateServiceModal').on('click', function (){
        $('#createServiceModal').css('display', 'none')
    })

    $('#store-service').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/services', formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Service created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('store-service').reset();
                $('#createServiceModal').css('display', 'none')
                fetchServices()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#service-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // service update
    $(document).on('click', '.editServiceButton', function() {
        $("#editServiceModal").css("display", "flex");
        $('.serviceCrudModal').hide();

        var serviceId = $(this).data('id');
        $('#update-service').attr('data-id', serviceId);

        axios.get(`/api/service/${serviceId}`)
            .then(response => {
                var serviceData = response.data;
                console.log(serviceData)
                $('#update-service-name').val(serviceData.name);
                $('#update-service-service_category').val(serviceData.service_category_id);
                $('#update-service-price').val(serviceData.price);
                $('#update-service-vat_rate').val(serviceData.vat_rate);
                $('#update-service-duration').val(serviceData.duration);

                if (serviceData.bookable_online) {
                    $('#update-service-bookable_online').prop('checked', true);
                } else {
                    $('#update-service-bookable_online').prop('checked', false);
                }

                serviceData.employees.forEach(employee => {
                    $('#update-employee-' + employee.id).prop('checked', true);
                });
            })
            .catch(error => {
                console.error('Error fetching service details:', error);
            });

    });

    $(document).on('click', '#closeEditServiceModal', function() {
        $("#editServiceModal").css("display", "none");
    });

    $('#update-service').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        let serviceId = $(this).data('id')

        axios.patch(`/api/services/${serviceId}`, formData)
            .then(response => {
                $('.alert-success').text('Service updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('update-service').reset();
                $('#editServiceModal').css('display', 'none')
                fetchServices()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-service-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // service delete
    $(document).on('click', '.deleteServiceButton', function() {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete service '
        }).then((result) => {
            if (result.isConfirmed) {
                let serviceId = $(this).data('id');

                axios.delete(`/api/services/${serviceId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your service has been deleted.', 'success');
                        fetchServices()
                    })
                    .catch(error => {
                        console.error('Error deleting service :', error);
                        Swal.fire('Error', 'Could not delete the service. Please try again.', 'error');
                    });
            }
        });
    })
})