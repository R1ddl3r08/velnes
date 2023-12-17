$(function () {

    $('#customerCreateButton').on('click', function () {
        $('#customerCreateModal').toggleClass('show');
        console.log('clicked');
    });

    $('#closeCreateCustomerModal').on('click', function () {
        $('#customerCreateModal').removeClass('show');
    });
    
    $(document).on('click', '.customerCrudModalButton', function () {
        var index = $('.customerCrudModalButton').index(this);

        $('.customerCrudModal').eq(index).toggle();
    });

    $(".editCustomerButton").click(function() {
        let customerId = $(this).data('id')
        window.customerIdForUpdate = customerId;
        $("#editCustomerModal").css("display", "flex");
        $('.customerCrudModal').hide()

        axios.get(`/api/customers/${customerId}`)
        .then(response => {
            let customer = response.data[0]
            console.log(customer)
            $('#customer-update #first_name').val(customer.first_name);
            $('#customer-update #last_name').val(customer.last_name);
            $('#customer-update #date_of_birth').val(customer.date_of_birth);

            $(`#customer-update #${customer.gender}`).prop('checked', true);

            $('#customer-update #email').val(customer.email);
            $('#customer-update #phone').val(customer.phone);
            $('#customer-update #address').val(customer.address);
            $('#customer-update #city').val(customer.city);
            $('#customer-update #postal_code').val(customer.postal_code);

            let customerGroupsDropdown = $('#customer-update #customer_groups');
            customerGroupsDropdown.empty();
            customerGroupsDropdown.append($('<option>', {
                value: 0,
                text: 'Select',
            }));
            customerGroupsDropdown.val(customer.customer_groups_id);

            $('#customer-update #warning').val(customer.warning);

        })
        .catch(error => {
            console.error(error);
        });

    });
  
    $("#closeEditCustomerModal").click(function() {
        $("#editCustomerModal").hide();
    });

    $(".deleteCustomerButton").click(function() {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete customer'
        }).then((result) => {
            if (result.isConfirmed) {
                let customerId = $(this).data('id');

                axios.delete(`/api/customers/${customerId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your customer has been deleted.', 'success');
                        $(`#${customerId}`).remove();
                    })
                    .catch(error => {
                        console.error('Error deleting customer:', error);
                        Swal.fire('Error', 'Could not delete the customer. Please try again.', 'error');
                    });
            }
        });
    });

    // Customer store
    $('#customer-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/customers/store', formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Customer created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('customer-store').reset();
                $('#customerCreateModal').removeClass('show');
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Customer update
    $('#customer-update').on('submit', function (e) {
        e.preventDefault();
        console.log('submitted')

        var formData = $(this).serialize();
        var customerId = window.customerIdForUpdate;

        axios.post(`/api/customers/update/${customerId}`, formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Customer updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $("#editCustomerModal").css("display", "none");
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

    // Customers search
    $('#customers-search').keyup(function () {
        var searchQuery = $(this).val();

        $.ajax({
            url: '/api/customers/search',
            type: 'GET',
            dataType: 'json',
            data: { search_query: searchQuery },
            success: function (data) {
                console.log(data)
                updateCustomersTable(data.customers);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    });

    function updateCustomersTable(customers) {
        $('tbody').empty();
        $.each(customers, function (index, customer) {
            var newRow = '<tr>' +
                '<td>' + customer.first_name + ' ' + customer.last_name + '</td>' +
                '<td>';

            if (customer.groups.length > 0) {
                newRow += '<ul>';
                $.each(customer.groups, function (groupIndex, group) {
                    newRow += '<li>' + group.name + '</li>';
                });
                newRow += '</ul>';
            } else {
                newRow += '/';
            }

            newRow += '</td>' +
                '<td>' + customer.phone + '</td>' +
                '<td>' + customer.email + '</td>' +
                '<td>';

            // Check if newsletter is true
            if (customer.newsletter) {
                newRow += '<img src="' + baseUrl + 'svg/check.svg" alt="">';
            } else {
                newRow += '<img src="' + baseUrl + 'svg/x.svg" alt="">';
            }
            
            newRow += '</td>' +
                '<td>' +
                '<button class="customerCrudModalButton"><img src="' + baseUrl + 'svg/three-dots.svg" alt=""></button>' +
                '<div class="crudModal customerCrudModal">' +
                '<button class="editCustomerButton" data-id="' + customer.id + '">' +
                '<img src="' + baseUrl + 'svg/pen.svg" alt="">' +
                'Edit' +
                '</button>' +
                '<button class="deleteCustomerButton" data-id="' + customer.id + '">' +
                '<img src="' + baseUrl + 'svg/trash-grey.svg" alt="">' +
                'Delete' +
                '</button>' +
                '</div>' +
                '</td>' +
                '</tr>';

            $('tbody').append(newRow);
        });
    }


    
});
