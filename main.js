document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    const rooms = ['Eger', 'Park', 'Kisterem', 'Nagyterem'];
    const days = ['2024-01-19', '2024-01-20', '2024-01-21'];
    const levels = [{
        title: 'Mindenki',
        bgColor: 'bg-primary'
    }, {
        title: 'Tematikus',
        bgColor: 'bg-warning'
    }, {
        title: 'Teljesen kezdő',
        bgColor: 'bg-danger'
    }, {
        title: 'Kezdő 2023',
        bgColor: 'bg-primary'
    }, {
        title: 'Középhaladó 2023',
        bgColor: 'bg-warning'
    }, {
        title: 'Középhaladó és Haladó',
        bgColor: 'bg-danger'
    }, {
        title: 'Haladó 2022',
        bgColor: 'bg-danger'
    }];

    const events =
        [
            {
                day: '2021-09-01',
                room: '1',
                hour: '10:00',
                title: 'Meeting',
                teachers: ['Teacher 1', 'Teacher 2'],
                danceStyle: 'bg-primary',
                danceLevel: 'bg-warning'
            },
            {
                day: '2021-09-01',
                room: '2',
                hour: '10:00',
                hourEnd: '12:00',
                title: 'Meeting',
                teachers: ['Teacher 1', 'Teacher 3'],
                danceStyle: 'bg-primary',
                danceLevel: 'bg-warning'
            },
        ];

    // collect unique teachers from events
    let teachers = [];
    events.forEach(event => {
        event.teachers.forEach(teacher => {
            if (teacher !== '' && !teachers.includes(teacher)) {
                teachers.push(teacher);
            }
        });
    });



    function createDayCalendar() {
        // for (let dayId = 0; dayId < days.length; dayId++) {
        dayId = 0;

        for (let roomId = 0; roomId < rooms.length; roomId++) {
            let roomDiv = document.createElement('div');

            roomDiv.classList.add('room');
            roomDiv.classList.add('border');
            roomDiv.classList.add('border-dark');
            roomDiv.classList.add('bg-warning');
            roomDiv.innerHTML = rooms[roomId];

            dayContent.appendChild(roomDiv);
        }

        calendarEl.appendChild(dayDiv);

    }

    createWeekCalendar();
});

