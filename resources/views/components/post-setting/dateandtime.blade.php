<div class="setting-block functionality-settings" data-type="dateandtime" style="display: none;">
            <div class="mb-4 border rounded p-3">
                <h5 class="mb-3">Date & Time Conditions</h5>

                <div class="mb-3">
                    <label class="form-label">Choose Date Format</label>
                    <select id="globalDateFormat" class="form-select">
                        <option value="yyyy-mm-dd">YYYY-MM-DD</option>
                        <option value="dd-mm-yyyy">DD-MM-YYYY</option>
                        <option value="mm-dd-yyyy">MM-DD-YYYY</option>
                        <option value="yyyy/dd/mm">YYYY/DD/MM</option>
                        <option value="dd M yyyy">DD MMM YYYY</option>
                    </select>
                </div>



                <!-- Additional Conditions for Remaining Date & Time Types -->
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Select Date Type</label>
                            <div class="d-flex flex-wrap gap-2">
                                <label><input type="radio" name="dateType" class="date-type-option" value="date">
                                    Date</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="datetime">
                                    Date &
                                    Time</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="lastdate">
                                    Last
                                    Date</label>
                                <label><input type="radio" name="dateType" class="date-type-option"
                                        value="previousdate">
                                    Previous Date</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="daterange">
                                    Date
                                    Range</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="time">
                                    Time</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="timer">
                                    Timer</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="countdown">
                                    Countdown</label>
                                <label><input type="radio" name="dateType" class="date-type-option"
                                        value="daycountdown"> Day
                                    Countdown</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="birthdate">
                                    Birth
                                    Date Picker</label>
                                <label><input type="radio" name="dateType" class="date-type-option"
                                        value="localcalendar">
                                    Localized Calendar</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="slider">
                                    Slider Time
                                    Picker</label>
                                <label><input type="radio" name="dateType" class="date-type-option" value="timetracker">
                                    Time
                                    Tracker</label>
                                <label><input type="radio" name="dateType" class="date-type-option"
                                        value="datereservation">
                                    Date Reservation</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="dateFieldsContainer">
                        <div class="col-md-12"><em>Please select a Date Type.</em></div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const container = document.getElementById('dateFieldsContainer');

                    const createInput = (label, type = 'text', id = '') => `
            <div class="col-md-6">
            <label class="form-label">${label}</label>
            <input type="${type}" id="${id}" class="form-control" placeholder="${label}">
            </div>`;

                    const renderDateFields = (type) => {
                        container.innerHTML = '';
                        switch (type) {
                            case 'birthdate':
                                container.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label">Select Birth Date</label>
                    <input type="date" id="birthDateInput" class="form-control" max="${new Date().toISOString().split('T')[0]}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Age (Years)</label>
                    <small class="form-control bg-light" id="ageYears"></small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Age (Days)</label>
                    <small class="form-control bg-light" id="ageDays"></small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Age Group</label>
                    <small class="form-control bg-light" id="ageGroup"></small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Time Until Next Birthday</label>
                    <small class="form-control bg-light" id="daysToBirthday"></small>
                </div>`;

                                setTimeout(() => {
                                    const input = document.getElementById(
                                        'birthDateInput');
                                    if (input) {
                                        input.max = new Date().toISOString()
                                            .split(
                                                'T')[0];
                                        input.addEventListener('change',
                                            function() {
                                                const birthDate = new Date(
                                                    this
                                                    .value);
                                                const today = new Date();
                                                let ageYrs = today
                                                    .getFullYear() -
                                                    birthDate
                                                    .getFullYear();
                                                const birthMonthDay =
                                                    new Date(
                                                        today.getFullYear(),
                                                        birthDate
                                                        .getMonth(),
                                                        birthDate.getDate()
                                                    );
                                                if (birthMonthDay > today)
                                                    ageYrs--;
                                                const ageDays = Math.floor((
                                                        today -
                                                        birthDate) /
                                                    (1000 * 60 * 60 *
                                                        24));

                                                const nextBirthday =
                                                    new Date(
                                                        today.getFullYear(),
                                                        birthDate
                                                        .getMonth(),
                                                        birthDate.getDate()
                                                    );
                                                if (nextBirthday < today)
                                                    nextBirthday
                                                    .setFullYear(
                                                        today
                                                        .getFullYear() + 1
                                                    );
                                                const totalDays = Math.ceil(
                                                    (
                                                        nextBirthday -
                                                        today
                                                    ) / (1000 * 60 *
                                                        60 * 24));

                                                const monthsLeft =
                                                    nextBirthday
                                                    .getMonth() - today
                                                    .getMonth() + (
                                                        nextBirthday
                                                        .getFullYear() >
                                                        today
                                                        .getFullYear() ?
                                                        12 : 0
                                                    );
                                                const daysLeft =
                                                    nextBirthday
                                                    .getDate() - today
                                                    .getDate();
                                                const formattedCountdown =
                                                    `${monthsLeft} month${monthsLeft !== 1 ? 's' : ''} ${daysLeft < 0 ? (30 + daysLeft) : daysLeft} day${daysLeft !== 1 ? 's' : ''}`;

                                                let group = 'Unknown';
                                                if (ageYrs < 1) group =
                                                    'Infant';
                                                else if (ageYrs < 3) group =
                                                    'Toddler';
                                                else if (ageYrs < 13)
                                                    group =
                                                    'Child';
                                                else if (ageYrs < 18)
                                                    group =
                                                    'Teenager';
                                                else if (ageYrs < 25)
                                                    group =
                                                    'Young Adult';
                                                else if (ageYrs < 41)
                                                    group =
                                                    'Adult';
                                                else if (ageYrs < 60)
                                                    group =
                                                    'Mid Age';
                                                else if (ageYrs < 76)
                                                    group =
                                                    'Senior';
                                                else group = 'Elderly';

                                                document.getElementById(
                                                        'ageYears')
                                                    .textContent = ageYrs;
                                                document.getElementById(
                                                        'ageDays')
                                                    .textContent =
                                                    ageDays;
                                                document.getElementById(
                                                        'ageGroup')
                                                    .textContent = group;
                                                document.getElementById(
                                                        'daysToBirthday')
                                                    .textContent =
                                                    formattedCountdown;
                                            });
                                    }
                                }, 100);
                                break;

                            case 'date':
                                container.innerHTML = createInput("Select Date",
                                    "date");
                                break;
                            case 'datetime':
                                container.innerHTML = createInput("Select Date & Time",
                                    "datetime-local");
                                break;
                            case 'daterange':
                                container.innerHTML = createInput("Start Date",
                                        "date") +
                                    createInput("End Date", "date");
                                break;
                            case 'countdown':
                                container.innerHTML = `
                    <div class="mb-3">
                    <label class="form-label">Select Countdown Target (Date & Time)</label>
                    <input type="datetime-local" id="countdownInput" class="form-control"
                        min="${new Date().toISOString().slice(0, 16)}">
                    </div>

                    <div id="countdownDetails" class="row g-3" style="display:none;">
                    <div class="col-md-4">
                        <label class="form-label">Target Date & Time</label>
                        <div id="targetDateTime" class="fw-semibold text-primary"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Days Left</label>
                        <div id="daysLeft" class="text-success fw-bold"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Time Left</label>
                        <div id="timeLeft" class="text-danger fw-bold"></div>
                    </div>
                    </div>
                `;

                                setTimeout(() => {
                                    const input = document.getElementById(
                                        'countdownInput');
                                    input?.addEventListener('change',
                                        function() {
                                            const target = new Date(this
                                                .value);
                                            const now = new Date();
                                            const countdownDetails =
                                                document
                                                .getElementById(
                                                    'countdownDetails');

                                            if (target <= now) {
                                                alert(
                                                    "Please select a future date & time."
                                                );
                                                return;
                                            }

                                            countdownDetails.style.display =
                                                'flex';
                                            document.getElementById(
                                                    'targetDateTime')
                                                .textContent = target
                                                .toLocaleString();

                                            const updateCountdown = () => {
                                                const now = new Date();
                                                const diff = target -
                                                    now;

                                                if (diff <= 0) {
                                                    document
                                                        .getElementById(
                                                            'daysLeft')
                                                        .textContent =
                                                        "0";
                                                    document
                                                        .getElementById(
                                                            'timeLeft')
                                                        .textContent =
                                                        "⏱ Time's Up!";
                                                    clearInterval(
                                                        interval);
                                                    return;
                                                }

                                                const days = Math.floor(
                                                    diff / (1000 *
                                                        60 *
                                                        60 * 24));
                                                const hours = Math
                                                    .floor((
                                                            diff / (
                                                                1000 *
                                                                60 * 60)
                                                        ) %
                                                        24);
                                                const minutes = Math
                                                    .floor((
                                                            diff / (
                                                                1000 *
                                                                60)) %
                                                        60);
                                                const seconds = Math
                                                    .floor((
                                                            diff / 1000
                                                        ) %
                                                        60);

                                                document.getElementById(
                                                        'daysLeft')
                                                    .textContent =
                                                    `${days} days`;
                                                document.getElementById(
                                                        'timeLeft')
                                                    .textContent =
                                                    `${hours}h ${minutes}m ${seconds}s`;
                                            };

                                            updateCountdown(); // initial
                                            const interval = setInterval(
                                                updateCountdown, 1000);
                                        });
                                }, 100);
                                break;


                            case 'lastdate':
                                container.innerHTML = createInput("Last Valid Date",
                                    "date");
                                break;
                            case 'previousdate':
                                container.innerHTML = createInput("Any Previous Date",
                                    "date");
                                break;
                                // Timer Countdown
                            case 'timer':
                                container.innerHTML = `
                        ${createInput("Enter Total Time (in minutes)", "number", "totalTimeInput")}
                        <div class="mt-3">
                        <button class="btn btn-primary" id="startTimerBtn">Start Timer</button>
                        <button class="btn btn-danger ms-2" id="stopTimerBtn">Stop Timer</button>
                        </div>
                        <div class="mt-3">
                        <label>Total Time:</label> <small class="text-muted" id="totalTimerView"></small><br>
                        <label>Time Left:</label> <small class="text-muted" id="timeLeftView"></small>
                        </div>`;

                                let timerInterval;

                                setTimeout(() => {
                                    const startBtn = document.getElementById(
                                        'startTimerBtn');
                                    const stopBtn = document.getElementById(
                                        'stopTimerBtn');
                                    const totalInput = document.getElementById(
                                        'totalTimeInput');

                                    startBtn?.addEventListener('click', () => {
                                        const totalMinutes = parseInt(
                                            totalInput.value);
                                        if (isNaN(totalMinutes) ||
                                            totalMinutes <= 0) return;

                                        const totalSeconds =
                                            totalMinutes *
                                            60;
                                        let remainingSeconds =
                                            totalSeconds;

                                        document.getElementById(
                                                'totalTimerView')
                                            .textContent =
                                            `${totalMinutes} minutes`;
                                        timerInterval = setInterval(
                                            () => {
                                                const mins = Math
                                                    .floor(
                                                        remainingSeconds /
                                                        60);
                                                const secs =
                                                    remainingSeconds %
                                                    60;
                                                document
                                                    .getElementById(
                                                        'timeLeftView'
                                                    )
                                                    .textContent =
                                                    `${mins}m ${secs}s`;

                                                if (remainingSeconds <=
                                                    0) {
                                                    clearInterval(
                                                        timerInterval
                                                    );
                                                    document
                                                        .getElementById(
                                                            'timeLeftView'
                                                        )
                                                        .textContent =
                                                        'Time Up!';
                                                } else {
                                                    remainingSeconds--;
                                                }
                                            }, 1000);
                                    });

                                    stopBtn?.addEventListener('click', () => {
                                        clearInterval(timerInterval);
                                    });
                                }, 100);
                                break;

                            case 'daycountdown':
                                container.innerHTML = createInput(
                                    "Days Countdown Target",
                                    "date") + createInput("Number of Days",
                                    "number");
                                break;
                            case 'slider':
                                container.innerHTML = `
                    <div class="col-md-12">
                        <label class="form-label">Slider Time Picker</label>
                        <input type="range" class="form-range" min="0" max="1440" step="15">
                        <small class="text-muted">Each step is 15 minutes (0 to 1440 min)</small>
                    </div>`;
                                break;
                            case 'timetracker':
                                container.innerHTML = createInput("Start Time",
                                        "time") +
                                    createInput("End Time", "time");
                                break;
                            case 'localcalendar':
                                container.innerHTML = `
                <div class="mb-3">
                <label class="form-label">Select Country for Local Calendar</label>
                <select id="localeSelector" class="form-select">
                    <option value="en-IN">India</option>
                    <option value="zh-CN">China</option>
                    <option value="ar-SA">Saudi Arabia</option>
                    <option value="ja-JP">Japan</option>
                    <option value="fr-FR">France</option>
                </select>
                </div>

                <div class="mb-3">
                <label class="form-label">Select Date</label>
                <input type="date" id="localizedDateInput" class="form-control">
                </div>

                <button class="btn btn-primary" id="testLocale">Test Format</button>

                <div class="mt-3">
                <label class="form-label">Localized Date Format</label>
                <div id="localizedResult" class="text-success fw-bold"></div>
                </div>
            `;

                                setTimeout(() => {
                                    const dateInput = document.getElementById(
                                        'localizedDateInput');
                                    const localeSelector = document
                                        .getElementById(
                                            'localeSelector');
                                    const testBtn = document.getElementById(
                                        'testLocale');

                                    testBtn?.addEventListener('click', () => {
                                        const selectedDate = new Date(
                                            dateInput.value);
                                        const locale = localeSelector
                                            .value;

                                        if (isNaN(selectedDate)) {
                                            document.getElementById(
                                                    'localizedResult')
                                                .textContent =
                                                'Please select a valid date';
                                            return;
                                        }

                                        const formatted = selectedDate
                                            .toLocaleDateString(
                                                locale, {
                                                    weekday: 'long',
                                                    year: 'numeric',
                                                    month: 'long',
                                                    day: 'numeric'
                                                });

                                        document.getElementById(
                                                'localizedResult')
                                            .textContent = formatted;
                                    });
                                }, 100);
                                break;

                            case 'datereservation':
                                container.innerHTML = createInput("Reserve Date",
                                        "date") +
                                    createInput("Time Slot", "time");
                                break;
                            default:
                                container.innerHTML =
                                    '<div class="col-md-12"><em>Please select a Date Type.</em></div>';
                        }
                    };

                    document.querySelectorAll('.date-type-option').forEach(radio => {
                        radio.addEventListener('change', () => renderDateFields(
                            radio
                            .value));
                    });
                });
                </script>




            </div>


        </div>