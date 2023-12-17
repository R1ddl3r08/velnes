$(function(){
    $('.scheduleButton').on('click', function(){
        $(this).addClass('active')
        $('.activityButton').removeClass('active')

        $('.schedule').show()
        $('.activity').hide()
    })

    $('.activityButton').on('click', function(){
        $(this).addClass('active')
        $('.scheduleButton').removeClass('active')

        $('.activity').show()
        $('.schedule').hide()
    });

    $('#employeesList').on('change', updateSchedule)

    function updateSchedule() {
        const selectedEmployeeId = document.getElementById('employeesList').value;

        const url = '/api/getAppointmentsByEmployee';
        const data = { employeeId: selectedEmployeeId };

        axios.get(url, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            params: data,
        })
        .then(response => {
            const appointments = response.data;
            console.log(appointments)

            let appointmentsContainer = document.createElement('div');

            if (appointments.length === 0) {
                appointmentsContainer.innerHTML = '<p class="no-appointments">No appointments for today</p>';
            } else {
                appointments.forEach(appointment => {
                    let appointmentDiv = document.createElement('div');
                    appointmentDiv.classList.add('appointment');

                    appointmentDiv.innerHTML = `
                        <div class="time">
                            <p class="start-time">${appointment.start_time}</p>
                            <p class="end-time">${appointment.end_time}</p>
                        </div>
                        <div class="profile-picture">
                            <div class="circle">
                                ${appointment.photo_url ? `<img src="${appointment.photo_url}" alt="Profile Picture">` : `<div class="circle"><p>${appointment.employee_name[0]}</p></div>`}
                            </div>
                        </div>
                        <div class="name-and-service">
                            <p class="name">${appointment.employee_name}</p>
                            <p class="service">${appointment.service_name}</p>
                        </div>
                    `;

                    appointmentsContainer.appendChild(appointmentDiv);
                });
            }

            document.getElementById('scheduleDiv').innerHTML = '';
            document.getElementById('scheduleDiv').appendChild(appointmentsContainer);
        })
        .catch(error => console.error('Error:', error));
    }
    
});