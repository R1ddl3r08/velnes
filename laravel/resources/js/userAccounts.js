$(function () {
    $(document).on('click', "#newUserAccountButton", function() {
        $("#newUserAccountModal").css("display", "flex");
    });
    
    $(document).on('click', "#closeNewUserAccountModal", function() {
        $("#newUserAccountModal").hide();
    });
    
    $(document).on('click', ".editUserAccountButton", function() {
        var accountId = $(this).data('id');

        axios.get(`/api/account/${accountId}`)
            .then(response => {
                $('#update-account-first_name').val(response.data.first_name);
                $('#update-account-last_name').val(response.data.last_name);
                $('#update-account-email').val(response.data.email);
                $('#update-account-phone_number').val(response.data.phone_number);

                console.log( $(`input[name="access"][value="${response.data.role_id}"]`))

                $(`input[name="access"][value="${response.data.role_id}"]`).prop('checked', true);

                // Show the modal
                $('#accounts-update').attr('data-id', response.data.id);
                $("#editUserAccountModal").css("display", "flex");
                $('.userAccountsCrudModal').hide();
            })
            .catch(error => {
                console.error('Error fetching account details:', error);
            });
    });
    
    $(document).on('click', "#closeEditUserAccountModal", function() {
        $("#editUserAccountModal").hide();
    });
    
    $(document).on('click', '.userAccountsCrudModalButton', function () {
        var index = $('.userAccountsCrudModalButton').index(this);
        $('.userAccountsCrudModal').eq(index).toggle();
    });
    
    $(document).on('click', ".deleteUserAccountButton", function() {
        // Use SweetAlert for the confirmation
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action. This will destroy all your data and will prevent you from being able to log into your account.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete account'
        }).then((result) => {
            if (result.isConfirmed) {
                let accountId = $(this).data('id');

                axios.delete(`/api/accounts/${accountId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your account has been deleted.', 'success');
                        fetchAccounts()
                    })
                    .catch(error => {
                        console.error('Error deleting account :', error);
                        Swal.fire('Error', 'Could not delete the account. Please try again.', 'error');
                    });
            }
        });
    });    

    function fetchAccounts()
    {
        let accountsTable = $('#user-accounts table tbody')

        axios.get('/api/accounts')
        .then(response => {
            accountsTable.empty()
            let accounts = response.data
            console.log(accounts)

            accounts.forEach(account => {
                const accountElement = $(`
                <tr>
                    <td>${account.email}</td>
                    <td>${account.first_name} ${account.last_name}</td>
                    <td>${account.role.name}</td>
                    <td class="userAccountsCrudModalField">
                        <button class="userAccountsCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                        <div class="crudModal userAccountsCrudModal">
                            <button class="editUserAccountButton" data-id="${account.id}">
                                <img src="${penIconUrl}" alt="">
                                Edit
                            </button>
                            <button class="deleteUserAccountButton" data-id="${account.id}">
                                <img src="${trashIconUrl}" alt="">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                `)

                accountsTable.append(accountElement)
            })
        })
        .catch(error => {
            console.error('Error fetching accounts:', error);
        });
    }

    fetchAccounts()

    // account store
    $('#accounts-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/accounts', formData)
            .then(response => {
                console.log(response.data);
                $('.alert-success').text('Account created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('accounts-store').reset();
                $('#newUserAccountModal').css('display', 'none')
                fetchAccounts()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#account-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // account update
    $('#accounts-update').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        let accountId = $(this).data('id')

        axios.patch(`/api/accounts/${accountId}`, formData)
            .then(response => {
                $('.alert-success').text('Account updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('accounts-update').reset();
                $('#editUserAccountModal').css('display', 'none')
                fetchAccounts()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-account-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })



})