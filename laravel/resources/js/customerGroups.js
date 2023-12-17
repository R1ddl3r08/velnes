$(function () {
    const threeDotsSvgPath = `${baseUrl}svg/three-dots.svg`;
    $(document).on('click', '#createCustomerGroupsButton', function() {
        $("#createCustomerGroupsModal").css("display", "flex");
    });
    
    $(document).on('click', '#closeCreateCustomerGroupsModal', function() {
        $("#createCustomerGroupsModal").hide();
    });
    
    $(document).on('click', '.editCustomerGroupsButton', function() {
        $("#editCustomerGroupsModal").css("display", "flex");
        $('.customerGroupsCrudModal').hide();

        var customerGroupId = $(this).data('id');
        window.customerGroupIdForUpdate = customerGroupId;

        axios.get(`/api/customerGroups/${customerGroupId}`)
            .then(response => {
                $('#update-customer-group-name').val(response.data.name);
            })
            .catch(error => {
                console.error('Error fetching customer group details:', error);
            });

    });
    
    $(document).on('click', '#closeEditCustomerGroupsModal', function() {
        $("#editCustomerGroupsModal").hide();
    });
    
    $(document).on('click', '.customerGroupsCrudModalButton', function () {
        var index = $('.customerGroupsCrudModalButton').index(this);
        $('.customerGroupsCrudModal').eq(index).toggle();
    });
    
    $(document).on('click', '.deleteCustomerGroupsButton', function() {
        // Use SweetAlert for the confirmation
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete customer group'
        }).then((result) => {
            if (result.isConfirmed) {
                let customerGroupId = $(this).data('id');

                axios.delete(`/api/customerGroups/${customerGroupId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your customer group has been deleted.', 'success');
                        $(`#customer-group-row-${customerGroupId}`).remove();
                    })
                    .catch(error => {
                        console.error('Error deleting customer group:', error);
                        Swal.fire('Error', 'Could not delete the customer group. Please try again.', 'error');
                    });
            }
        });
    });
    

    // Index
    axios.get('/api/customerGroups')
    .then(response => {
        const customerGroupsTbody = $('#customer-groups tbody');

        customerGroupsTbody.empty();

        response.data.forEach(customerGroup => {
            const showCrudModalButtons = customerGroup.id !== 1 && customerGroup.id !== 2;

            const customerGroupElement = `
                <tr id="customer-group-row-${customerGroup.id}">
                    <td>${customerGroup.name}</td>
                    <td>${customerGroup.customers.length}</td>
                    <td>
                        ${showCrudModalButtons ? `
                            <button class="customerGroupsCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                            <div class="crudModal customerGroupsCrudModal">
                                <button class="editCustomerGroupsButton" data-id="${customerGroup.id}">
                                    <img src="${baseUrl}svg/pen.svg" alt="">
                                    Edit
                                </button>
                                <button class="deleteCustomerGroupsButton" data-id="${customerGroup.id}">
                                    <img src="${baseUrl}svg/trash-grey.svg" alt="">
                                    Delete
                                </button>
                            </div>
                        ` : ''}
                    </td>
                </tr>
            `;
            customerGroupsTbody.append(customerGroupElement);
        });
    })
    .catch(error => {
        console.error('Error fetching customer groups:', error);
    });

    // Customer group store
    $('#customer-group-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/customerGroups/store', formData)
            .then(response => {
                $('.alert-success').text('Customer group created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('customer-group-store').reset();
                $('#createCustomerGroupsModal').css("display", "none");
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#customer-group-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Customer group update
    $('#customer-group-update').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var customerGroupId = window.customerGroupIdForUpdate;

        axios.patch(`/api/customerGroups/update/${customerGroupId}`, formData)
            .then(response => {
                $('.alert-success').text('Customer group updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $("#editCustomerGroupsModal").css("display", "none");
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-customer-group' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

})