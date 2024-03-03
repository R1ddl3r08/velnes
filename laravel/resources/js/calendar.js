$(function() {
    $('#eventCreateButton').on('click', function () {
        $('#eventCreateModal').toggleClass('show');
    });

    $('#newAppointmentButton').on('click', function () {
        $('#eventCreateModal').toggleClass('show');
    });

    $('#closeEventCreateModalButton').on('click', function () {
        $('#eventCreateModal').removeClass('show');
    });

    let activeButton = $('#btnAppointment');

    $('.options button').click(function() {
        activeButton.removeClass('active');

        $('.create-appointment, .create-absence, .create-chore, .create-note').hide();

        var buttonId = $(this).attr('id');

        $('#create' + buttonId.replace('btn', '')).show();

        activeButton = $(this);

        activeButton.addClass('active');
    });

    $(document).ready(function () {
        $('#range, #employees, #datePicker').change(updateTable);
        $('.previousDayBtn, .nextDayBtn').click(updateTable);
        $('.todayButton').click(updateTable);
    });

    updateTable()

    function showNoAppointmentsMessage() {
        const noAppointmentsMessage = '<p class="no-appointments-message">No Appointments for Today</p>';
        const calendarTable = $('.calendar-table');

        calendarTable.after(noAppointmentsMessage);
        calendarTable.hide();
    }

    function clearNoAppointmentsMessage() {
        $('.no-appointments-message').remove();
        $('.calendar-table').show();
    }

    function updateTable() {
        let rangeValue = $('#range').val();
        let employeesValue = $('#employees').val();
        let dateValue = $('#datePicker').val();
        const today = $('#datePicker').val();

        axios.get(`/api/appointments/${dateValue}/${rangeValue}/${employeesValue}`)
            .then(function (response) {
                if (rangeValue === 'week') {
                    handleWeekView(response.data.days, response.data.appointments, today);
                } else if (rangeValue === 'day') {
                    handleDayView(response.data.employees, response.data.appointments, today);
                }

                if (employeesValue !== 0 && response.data.appointments.length === 0) {
                    clearNoAppointmentsMessage();
                    showNoAppointmentsMessage();
                } else {
                    clearNoAppointmentsMessage();
                }
            })
            .catch(function (error) {
                console.error('Error fetching appointments:', error);
            });
    }

    function handleWeekView(days, appointments, today) {
        const theadRow = $('.calendar-table thead tr');
        const tbody = $('.calendar-table tbody');
    
        let tableHeader = '<th>W-19</th>';
        days.forEach(day => {
            tableHeader += `<th>${day}</th>`;
        });
        theadRow.html(tableHeader);

    
        // -----
        tbody.html('');
    
        for (let hour = 8; hour <= 15; hour++) {
            for (let minute = 0; minute < 60; minute += 15) {
                if (hour === 15 && minute === 0) {
                    break;
                }
    
                const row = $('<tr>');
                row.append(`<td class="timestamp">${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}</td>`);
                
                days.forEach(day => {
                    const formattedDay = moment(day, 'ddd D').format('YYYY-MM-DD');
                    row.append(`<td ${formattedDay === today ? ' class="today empty-slot"' : 'class="empty-slot"'}></td>`);
                });
                
                tbody.append(row);  
            }
        }

        appointments.forEach(appointment => {
            const startTime = moment(appointment.date_time);
            const endTime = startTime.clone().add(appointment.duration, 'minutes');
            const durationInSlots = appointment.durationInSlots;
        
            const columnIndex = days.indexOf(startTime.format('ddd DD'));
            const rowIndex = (startTime.hours() - 8) * 4 + startTime.minutes() / 15;
        
            const cell = $(`.calendar-table tbody tr:eq(${rowIndex}) td:eq(${columnIndex + 1})`);
        
            const appointmentDiv = $(`
            <div class="appointment slot-${durationInSlots}" data-id="${appointment.id}">
                <div class="inner-appointment">
                    <div class="info">
                        <div>
                        <p>${formatTime(startTime.hours(), startTime.minutes())} - ${formatTime(endTime.hours(), endTime.minutes())}</p>
                        <p class="name">${appointment.employee.name}</p>
                        <p>${appointment.service.name}</p>
                        </div>
                    <p> <img src="${profileIconUrl}"> ${appointment.customer.name}</p>
                    </div>
            </div>
            </div>`);

            let color = appointment.service.category.color
            appointmentDiv.css({
                'background-color': blendWithWhite(color, 0.7),
                'border-left': `4px solid ${color}`
            });
        
            cell.html(appointmentDiv);
            cell.removeClass('empty-slot').addClass('occupied-slot');
        });
    }
    

    function handleDayView(employees, appointments, today) {
        const theadRow = $('.calendar-table thead tr');
        const tbody = $('.calendar-table tbody');
        const calendarTable = $('.calendar-table');
    
        let headerContent = '<th>W-19</th>';
        employees.forEach(employee => {
            headerContent += `<th>${employee.name}</th>`;
        });
        theadRow.html(headerContent);
    
        //--------
        tbody.html('');
    
        for (let hour = 8; hour <= 15; hour++) {
            for (let minute = 0; minute < 60; minute += 15) {
                if (hour === 15 && minute === 0) {
                    break;
                }
    
                const row = $('<tr>');
                row.append(`<td class="timestamp">${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}</td>`);
    
                employees.forEach(employee => {
                    const matchingAppointments = appointments.filter(appointment => {
                        const startTime = moment(appointment.date_time);
                        return (
                            startTime.hours() === hour &&
                            startTime.minutes() === minute &&
                            appointment.employee.id === employee.id
                        );
                    });
    
                    const cell = $('<td class="empty-slot"></td>');
    
                    if (matchingAppointments.length > 0) {
                        matchingAppointments.forEach(appointment => {
                            const startTime = moment(appointment.date_time);
                            const endTime = startTime.clone().add(appointment.duration, 'minutes');
                            const durationInSlots = appointment.durationInSlots;
                            const appointmentDiv = $(
                                `
                                <div class="appointment slot-${durationInSlots}" data-id="${appointment.id}">
                                    <div>
                                        <p>${formatTime(startTime.hours(), startTime.minutes())} - ${formatTime(endTime.hours(), endTime.minutes())}</p>
                                        <p class="name">${appointment.employee.name}</p>
                                        <p>${appointment.service.name}</p>
                                    </div>
                                    <p> <img src="${profileIconUrl}"> ${appointment.customer.name}</p>
                                </div>`
                            );
    
                            // Apply styles to appointmentDiv
                            let color = appointment.service.category.color;
                            appointmentDiv.css({
                                'background-color': blendWithWhite(color, 0.3),
                                'border-left': `4px solid ${color}`
                            });
    
                            cell.removeClass('empty-slot').addClass('occupied-slot');
                            cell.append(appointmentDiv);
                        });
                    }
    
                    row.append(cell);
                });
    
                tbody.append(row);
            }
        }
    }
    
    

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

    function formatTime(hours, minutes) {
        return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
    }



    $('.nextDayBtn').on('click', function () {
        changeDate(1);
    });

    $('.previousDayBtn').on('click', function () {
        changeDate(-1);
    });

    $('.todayButton').on('click', function () {
        setTodayDate();
    });

    function setTodayDate() {
        const datePicker = $('#datePicker');
        const todayDate = moment().format('YYYY-MM-DD');
        datePicker.val(todayDate);
    }

    function changeDate(daysToAdd) {
        const datePicker = $('#datePicker');
        const currentDate = moment(datePicker.val(), 'YYYY-MM-DD');
        const newDate = currentDate.add(daysToAdd, 'days').format('YYYY-MM-DD');
        datePicker.val(newDate);
    }

    $(document).on('click', '.appointment', function () {
        let appointmentId = $(this).data('id');
        
        axios.get(`/api/appointment/${appointmentId}`)
        .then(function (response) {
            let appointmentData = response.data;

            let startTime = moment(appointmentData.date_time);
            let endTime = startTime.clone().add(appointmentData.duration, 'minutes');

            $('#appointmentDetailsModal .date').text(moment(appointmentData.date_time).format('YYYY-MM-DD'));
            $('#appointmentDetailsModal .time').html(`${startTime.format('HH:mm')} - ${endTime.format('HH:mm')}`);
            $('#appointmentDetailsModal .price').html(`&euro;${appointmentData.service.price}`);
            if(appointmentData.note){
                $('.warning').show()
            }
            let serviceTableBody = $('#appointment-details-table tbody');
            serviceTableBody.empty();

            let serviceRow = `<tr>
                                <td>${appointmentData.service.name}</td>
                                <td>${appointmentData.duration} minutes</td>
                                <td>${appointmentData.employee.name}</td>
                           </tr>`;
            serviceTableBody.append(serviceRow);

            // Populate customer details
            $('#appointmentDetailsModal .customer-name').text(`${appointmentData.customer.first_name} ${appointmentData.customer.last_name}`);
            $('#appointmentDetailsModal .customer-email').text(appointmentData.customer.email);
            $('#appointmentDetailsModal .customer-phone').text(appointmentData.customer.phone);

            let customerFirstName = appointmentData.customer.first_name;
            let customerFirstLetter = customerFirstName.charAt(0).toUpperCase();
            $('#appointmentDetailsModal .profile-picture p').text(customerFirstLetter);

            // Populate employee details
            $('#appointmentDetailsModal .employee-name').text(appointmentData.employee.name);
            // Add other employee details as needed

            $('#editAppointmentButton').attr('data-id', appointmentData.id);
            $('#deleteAppointmentButton').attr('data-id', appointmentData.id);
            // Show the modal
            $('#appointmentDetailsModal').css('display', 'flex');
        })
        .catch(function (error) {
            console.error('Error fetching appointment details:', error);
        });
    });

    $('#closeAppointmentDetailsModal').on('click', function () {
        $('#appointmentDetailsModal').css('display', 'none')
    })

    $('#appointment-date, #appointment-time').on('change', function () {
        if ($('#appointment-date').val() !== '' && $('#appointment-time').val() !== '') {
            $('.selectedDate').show();
            $('.selectedDate p').html(`
                ${$('#appointment-date').val()}, ${$('#appointment-time').val()}
            `);
        } else {
            $('.selectedDate').hide();
        }
    });

    $('#appointment-service').on('change', function () {
        let selectedOption = $('#appointment-service option:selected');
    
        if (selectedOption.val() !== '0') {
            let servicePrice = selectedOption.data('price');
            $('.totalPrice').show();
            $('.totalPrice p').html(`&euro;${servicePrice}`);
        } else {
            $('.totalPrice').hide();
        }
    })


    // Appointment store
    $('#appointment-store').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        axios.post('/api/appointments/store', formData)
            .then(response => {
                $('.alert-success').text('Appointment created successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $('#eventCreateModal').removeClass('show');
                updateTable()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#appointment-' + field + '-error').html(messages[0]);
                        $(`[name="${field}"]`).addClass('error');
                    });

                    $('.form-control').removeClass('error');

                } else {
                    console.error(error.response.data);
                }
            });
    })

    function populateServiceDetails(serviceId, durationInput, employeeSelect) {
        axios.get(`/api/service/${serviceId}`)
            .then(function (response) {
                var service = response.data;
    
                durationInput.val(service.duration);
    
                employeeSelect.empty();
                employeeSelect.append('<option value="0">Employees</option>');
    
                $.each(service.employees, function (index, employee) {
                    employeeSelect.append('<option value="' + employee.id + '">' + employee.name + '</option>');
                });
            })
            .catch(function (error) {
                console.error('Error fetching service details:', error);
            });
    }
    
    // Use the function for the first scenario
    $('#appointment-service').on('change', function () {
        var serviceId = $(this).val();
        var durationInput = $('#appointment-duration');
        var employeeSelect = $('#appointment-employee');
    
        populateServiceDetails(serviceId, durationInput, employeeSelect);
    });
    
    $('#update-appointment-service').on('change', function () {
        var serviceId = $(this).val();
        var durationInput = $('#update-appointment-duration');
        var employeeSelect = $('#update-appointment-employee');
    
        populateServiceDetails(serviceId, durationInput, employeeSelect);
    });
    

    //Appointment update
    $('#closeEditAppointmentModalButton').click(function () {
        $('#editAppointmentModal').css('display', 'none')
    })
    $('#editAppointmentButton, .editAppointmentButton').click(function (){
        $('#appointmentDetailsModal').css('display', 'none')
        $('#editAppointmentModal').css('display', 'flex')

        let appointmentId = $(this).data('id')

        axios.get(`/api/appointment/${appointmentId}`)
        .then(function (response) {
            let appointmentData = response.data;

            let serviceId = appointmentData.service_id
            let durationInput = $('#update-appointment-duration')
            let employeeSelect = $('#update-appointment-employee')

            populateServiceDetails(serviceId, durationInput, employeeSelect);

            $('#update-appointment-service').val(appointmentData.service_id);
            $('#update-appointment-duration').val(appointmentData.duration);
            $('#update-appointment-employee').val(appointmentData.employee_id);
            $('#update-appointment-room').val(appointmentData.room_id);
            $('#update-appointment-tool1').val(appointmentData.tool_1_id);
            $('#update-appointment-tool2').val(appointmentData.tool_2_id);
            $('#update-appointment-date').val(appointmentData.date_time.split(' ')[0]);
            $('#update-appointment-time').val(appointmentData.date_time.split(' ')[1]);
            $('#update-appointment-customer').val(appointmentData.customer_id);

            $('#appointment-update').attr('data-id', appointmentData.id);

            $('#editAppointmentModal').css('display', 'flex');
        })
        .catch(function (error) {
            console.error(error);
        });
    })

    $('#appointment-update').on('submit', function (e) {
        e.preventDefault();

        var formData = $(this).serialize();
        var appointmentId = $(this).data('id');

        axios.patch(`/api/appointments/update/${appointmentId}`, formData)
            .then(response => {
                $('.alert-success').text('Appointment updated successfully').addClass('show');

                setTimeout(function () {
                    $('.alert-success').removeClass('show').text('');
                }, 3000);
                $("#editAppointmentModal").css("display", "none");
                updateTable()
            })
            .catch(error => {
                if (error.response.status === 422) {
                    $('.error-message').empty();
    
                    $.each(error.response.data.errors, function (field, messages) {
                        $('#update-appointment-' + field + '-error').html(messages[0]);
                    });
                } else {
                    console.error(error.response.data);
                }
            });
    })

    // Appointment delete
    $("#deleteAppointmentButton, .deleteAppointmentButton").click(function() {
        $('#appointmentDetailsModal').css('display', 'none')
        Swal.fire({
            title: 'Do you want to proceed?',
            text: "Warning! You cannot revert this action.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E35D4E',
            cancelButtonColor: '#3660B2',
            confirmButtonText: 'Delete appointment'
        }).then((result) => {
            if (result.isConfirmed) {
                let appointmentId = $(this).data('id');

                axios.delete(`/api/appointments/${appointmentId}`)
                    .then(response => {
                        Swal.fire('Deleted!', 'Your appointment has been deleted.', 'success');

                        updateTable()
                    })
                    .catch(error => {
                        console.error('Error deleting appointment:', error);
                        Swal.fire('Error', 'Could not delete the appointment. Please try again.', 'error');
                    });
            }
        });
    });
});