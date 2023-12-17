$(function () {
    $(document).on('click', "#createResourceButton", function () {
        $("#createResourceModal").css("display", "flex");
    });

    $(document).on('click', "#closeCreateResourceModal", function () {
        $("#createResourceModal").hide();
    });

    $(document).on('click', "#closeEditResourceModal", function () {
        $("#editResourceModal").hide();
    });

    // Toggle Resource Crud Modal
    $(document).on('click', ".editResourceButton", function () {
        var resourceId = $(this).data('id');
        var resourceType = $(this).data('type');

        $("#editResourceModal").css("display", "flex");
        $('#resources-update').data('id', resourceId);
        $('#resources-update').data('type', resourceType);
        $('.resourceCrudModal').hide();
    
        axios.get(`/api/resource/${resourceType}/${resourceId}`)
            .then(response => {
                $("#update-resources-name").val(response.data.name);
                $(`#update-resources-${resourceType}`).prop('checked', true)

                if (response.data.bookable_online) {
                    $("#update-resources-bookable_online").prop('checked', true);
                } else {
                    $("#update-resources-bookable_online").prop('checked', false);
                }
    
            })
            .catch(error => {
                console.error('Error fetching resource details:', error);
            });
    });

    $(document).on('click', '.resourceCrudModalButton', function () {
        var index = $('.resourceCrudModalButton').index(this);
    
        $('.resourceCrudModal').eq(index).toggle();
    });

    // Delete Resource Button with SweetAlert confirmation
    $(document).on('click', ".deleteResourceButton", function () {
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete resource'
        }).then((result) => {
            if (result.isConfirmed) {
                let resourceId = $(this).data('id');
                let resourceType = $(this).data('type');

                axios.delete(`/api/resources/${resourceType}/${resourceId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your resource has been deleted.', 'success');
                        fetchResources()
                    })
                    .catch(error => {
                        console.error('Error deleting resource :', error);
                        Swal.fire('Error', 'Could not delete the resource. Please try again.', 'error');
                    });
            }
        });
    });

    function createResourceElement(id, name, servicesCount, isRoom) {
        let resourceType = isRoom ? 'rooms' : 'tools';

        return $(`
            <div class="resource">
                <div class="identity">
                    <div class="profile-picture">
                        <div class="circle">
                            <p>${name.charAt(0).toUpperCase()}</p>
                        </div>
                    </div>
                    <p class="name">${name}</p>
                </div>
                <div class="group">
                    <button class="resourceCrudModalButton"><img src="${threeDotsSvgPath}" alt=""></button>
                    <div class="crudModal resourceCrudModal">
                        <button class="editResourceButton" data-id="${id}" data-type="${resourceType}">
                            <img src="${penIconUrl}" alt="">
                            Edit
                        </button>
                        <button class="deleteResourceButton" data-id="${id}" data-type="${resourceType}">
                            <img src="${trashIconUrl}" alt="">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        `);
    }

    // resources index
    function fetchResources() {
        axios.get('/api/resources')
            .then(response => {
                let rooms = response.data.rooms;
                let tools = response.data.tools;
    
                // Function to create a resource element
    
                // Append rooms to .resources-div.rooms
                let roomsContainer = $('.resources-div.rooms');
                roomsContainer.empty()
                roomsContainer.html(`<label for="">Active rooms</label>`)
                rooms.forEach(room => {
                    let roomElement = createResourceElement(room.id, room.name, room.services_count, true);
                    roomsContainer.append(roomElement);
                });
    
                // Append tools to .resources-div.tools
                let toolsContainer = $('.resources-div.tools');
                toolsContainer.empty()
                toolsContainer.html(`<label for="">Active tools</label>`)
                tools.forEach(tool => {
                    let toolElement = createResourceElement(tool.id, tool.name, tool.services_count, false);
                    toolsContainer.append(toolElement);
                });
            })
            .catch(error => {
                console.error('Error fetching resources:', error);
            });
    }
    
    fetchResources();

    // resources search
    $('#search_resources').keyup(function () {
        var searchQuery = $(this).val();
    
        if (searchQuery !== '') {
            $.ajax({
                url: '/api/resources/search',
                type: 'GET',
                dataType: 'json',
                data: { search_query: searchQuery },
                success: function (response) {
                    updateResourcesDiv(response);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        } else {
            fetchResources();
        }
    });
    
    function updateResourcesDiv(resources) {
        $('.resources-div.rooms').empty();
        $('.resources-div.tools').empty();
    
        resources.rooms.forEach(room => {
            let roomElement = createResourceElement(room.id, room.name, room.services_count, true);
            $('.resources-div.rooms').append(roomElement);
        });
    
        resources.tools.forEach(tool => {
            let toolElement = createResourceElement(tool.id, tool.name, tool.services_count, false);
            $('.resources-div.tools').append(toolElement);
        });
    }

    // resource filter
    $('#resources-type').on('change', function () {
        var selectedValue = $(this).val();

        if (selectedValue === 'rooms' || selectedValue === 'tools') {
            fetchResourcesByType(selectedValue);
        }
    });
    function fetchResourcesByType(resourceType) {
        $.ajax({
            url: '/api/resources/filter/' + resourceType,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log(response)
                $('.resources-div.rooms').empty()
                $('.resources-div.tools').empty()
                if(response.type == 'rooms'){
                    $('.resources-div.rooms').html(`<label for="">Active rooms</label>`)
                    response.resources.forEach(resource => {
                        let resourceElement = createResourceElement(resource.id, resource.name, resource.services_count, true);
                        $('.resources-div.rooms').append(resourceElement);
                    });
                }
                if(response.type == 'tools'){
                    $('.resources-div.tools').html(`<label for="">Active tools</label>`)
                    response.resources.forEach(resource => {
                        let resourceElement = createResourceElement(resource.id, resource.name, resource.services_count, true);
                        $('.resources-div.tools').append(resourceElement);
                    });
                }
                if(response.type == '0'){
                    fetchResources()
                }
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });

    }

    // resources store
    $('#resources-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/resources', formData)
            .then(response => {
                $('.alert-success').text('Resource created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('resources-store').reset();
                $('#createResourceModal').css('display', 'none')
                fetchResources()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#resource-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // resources update
    $('#resources-update').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        let resourceId = $(this).data('id')
        let resourceType = $(this).data('type')

        axios.patch(`/api/resources/${resourceType}/${resourceId}`, formData)
            .then(response => {
                $('.alert-success').text('Resource updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                document.getElementById('update-resources').reset();
                $("#editResourceModal").hide();
                fetchResources()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-resources-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })
    
})