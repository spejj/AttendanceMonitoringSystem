<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>AMS - Instructor Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="bg-gray-soft">
  <div class="app-root">
    <header class="topbar">
      <nav class="container nav-flex">
        <div class="brand">AMS</div>

        <div class="nav-links hide-sm">
          <button data-view="admin" class="nav-btn">Admin</button>
          <button data-view="instructor" class="nav-btn active">Instructor</button>
          <button data-view="student-parent" class="nav-btn">Student/Parent</button>
        </div>

        <div class="nav-right">
          <span id="welcomeText" class="muted hide-md">Welcome, Instructor</span>
          <button id="logoutBtn" class="btn secondary sm">Logout</button>
        </div>
      </nav>
    </header>

    <main class="container page-content">
      <div class="space-y">
        <div>
          <h2 class="page-title">Instructor Dashboard</h2>
          <p class="muted">Today is Wednesday, October 15, 2025.</p>
        </div>

        <div class="grid-3">
          <div class="card lg-col-2 text-center">
            <p class="muted">Your current class is:</p>
            <h3 class="big-title">ITEL 304 (Section B)</h3>
            <p class="muted">2:00 PM - 3:30 PM</p>
            <button id="startAttendanceBtn" class="btn primary large mt-6">START ATTENDANCE NOW</button>
          </div>

          <div class="stack">
            <div class="card">
              <h3>Recent Class Attendance</h3>
              <div class="chart-box" id="instructorBarChart"></div>
            </div>

            <div class="card warning">
              <h3>Grade Status Alert</h3>
              <p class="muted">4/5 classes have updated grades for this period.</p>
              <button class="btn secondary w-full">View Missing Grades</button>
            </div>
          </div>
        </div>

        <!-- Attendance Analytics Section -->
        <div class="grid-2">
          <div class="card">
            <div class="flex-between">
              <h3>Attendance Analytics</h3>
              <select id="subjectFilter" class="select sm">
                <option value="all">All Subjects</option>
                <option value="ITEL304">ITEL 304</option>
                <option value="ITST301">ITST 301</option>
              </select>
            </div>
            <div class="grid-stats mt-6">
              <div class="stat">
                <div class="stat-icon green">
                  <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 13l4 4L19 7"></path>
                  </svg>
                </div>
                <div>
                  <div class="stat-value" id="presentRate">95%</div>
                  <div class="muted">Present Rate</div>
                </div>
              </div>
              <div class="stat">
                <div class="stat-icon red">
                  <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </div>
                <div>
                  <div class="stat-value" id="absentRate">3%</div>
                  <div class="muted">Absent Rate</div>
                </div>
              </div>
              <div class="stat">
                <div class="stat-icon amber">
                  <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 8v4l3 3"></path>
                    <circle cx="12" cy="12" r="10"></circle>
                  </svg>
                </div>
                <div>
                  <div class="stat-value" id="lateRate">2%</div>
                  <div class="muted">Late Rate</div>
                </div>
              </div>
            </div>
            <div class="chart-box mt-6" id="attendanceTrendChart"></div>
          </div>

          <div class="card">
            <div class="flex-between">
              <h3>Student Performance</h3>
              <button class="btn secondary sm" id="exportStatsBtn">Export Report</button>
            </div>
            <div class="table-wrap mt-6">
              <table class="table">
                <thead>
                  <tr>
                    <th>Student</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Late</th>
                  </tr>
                </thead>
                <tbody id="studentStatsBody">
                  <!-- Populated by JavaScript -->
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Class Schedule Management -->
        <div class="card">
          <div class="flex-between">
            <h3>Class Schedule Management</h3>
            <button class="btn primary sm" id="addScheduleBtn">Add New Schedule</button>
          </div>
          <div class="table-wrap mt-6">
            <table class="table">
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>Section</th>
                  <th>Schedule</th>
                  <th>Room</th>
                  <th>Recurring</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="scheduleBody">
                <!-- Sample data - will be dynamic -->
                <tr>
                  <td>
                    <div><strong>ITEL 304</strong></div>
                    <div class="muted small">Web Systems and Technologies</div>
                  </td>
                  <td>Section B</td>
                  <td>
                    <div class="mono">2:00 PM - 3:30 PM</div>
                    <div class="muted small">Monday, Wednesday</div>
                  </td>
                  <td>Room 301</td>
                  <td><span class="badge green">Weekly</span></td>
                  <td>
                    <div class="btn-group">
                      <button class="btn secondary sm edit-schedule" data-id="1">Edit</button>
                      <button class="btn destructive sm delete-schedule" data-id="1">Delete</button>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <div><strong>ITST 301</strong></div>
                    <div class="muted small">Information Assurance</div>
                  </td>
                  <td>Section A</td>
                  <td>
                    <div class="mono">4:00 PM - 5:00 PM</div>
                    <div class="muted small">Tuesday, Friday</div>
                  </td>
                  <td>Room 405</td>
                  <td><span class="badge green">Weekly</span></td>
                  <td>
                    <div class="btn-group">
                      <button class="btn secondary sm edit-schedule" data-id="2">Edit</button>
                      <button class="btn destructive sm delete-schedule" data-id="2">Delete</button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Today's Classes (Moved below schedule management) -->
        <div class="card">
          <h3>Today's Upcoming Classes</h3>
          <ul class="list-plain">
            <li class="list-item">
              <div>
                <strong>ITST 301</strong>
                <div class="muted">Section A</div>
              </div>
              <div class="mono">4:00 PM - 5:00 PM</div>
            </li>
          </ul>
        </div>
      </div>
    </main>
  </div>

  <!-- Schedule Modal -->
  <div class="modal" id="scheduleModal" aria-hidden="true">
    <div class="modal-content card">
      <h3 id="scheduleModalTitle">Add New Schedule</h3>
      <div class="space-y">
        <div>
          <label class="label">Subject Code</label>
          <input type="text" id="subjectCode" class="input" placeholder="e.g. ITEL 304" />
        </div>
        <div>
          <label class="label">Subject Title</label>
          <input type="text" id="subjectTitle" class="input" placeholder="e.g. Web Systems and Technologies" />
        </div>
        <div>
          <label class="label">Section</label>
          <input type="text" id="section" class="input" placeholder="e.g. Section B" />
        </div>
        <div class="grid-2">
          <div>
            <label class="label">Start Time</label>
            <input type="time" id="startTime" class="input" />
          </div>
          <div>
            <label class="label">End Time</label>
            <input type="time" id="endTime" class="input" />
          </div>
        </div>
        <div>
          <label class="label">Room</label>
          <input type="text" id="room" class="input" placeholder="e.g. Room 301" />
        </div>
        <div>
          <label class="label">Days</label>
          <div class="space-y">
            <label><input type="checkbox" name="days" value="Monday"> Monday</label>
            <label><input type="checkbox" name="days" value="Tuesday"> Tuesday</label>
            <label><input type="checkbox" name="days" value="Wednesday"> Wednesday</label>
            <label><input type="checkbox" name="days" value="Thursday"> Thursday</label>
            <label><input type="checkbox" name="days" value="Friday"> Friday</label>
          </div>
        </div>
        <div>
          <label class="label">Recurring Pattern</label>
          <select id="recurringPattern" class="select">
            <option value="weekly">Weekly</option>
            <option value="biweekly">Bi-weekly</option>
            <option value="monthly">Monthly</option>
          </select>
        </div>
        <div class="flex-between mt-6">
          <button class="btn secondary" id="cancelSchedule">Cancel</button>
          <button class="btn primary" id="saveSchedule">Save Schedule</button>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/charts.js"></script>
  <script src="assets/js/main.js"></script>
  <script>
    // Initialize attendance trend chart
    const attendanceTrend = document.getElementById('attendanceTrendChart');
    if (attendanceTrend) {
      window.renderLineChart(attendanceTrend, [95, 92, 97, 94, 96, 93, 95]);
    }

    // Schedule Management
    const scheduleModal = document.getElementById('scheduleModal');
    const addScheduleBtn = document.getElementById('addScheduleBtn');
    const cancelScheduleBtn = document.getElementById('cancelSchedule');
    const saveScheduleBtn = document.getElementById('saveSchedule');
    const scheduleBody = document.getElementById('scheduleBody');

    // Store schedules in memory (in a real app, this would be in a database)
    let schedules = [
      {
        id: 1,
        subjectCode: 'ITEL 304',
        subjectTitle: 'Web Systems and Technologies',
        section: 'Section B',
        startTime: '14:00',
        endTime: '15:30',
        room: 'Room 301',
        days: ['Monday', 'Wednesday'],
        recurring: 'weekly'
      },
      {
        id: 2,
        subjectCode: 'ITST 301',
        subjectTitle: 'Information Assurance',
        section: 'Section A',
        startTime: '16:00',
        endTime: '17:00',
        room: 'Room 405',
        days: ['Tuesday', 'Friday'],
        recurring: 'weekly'
      }
    ];

    // Utility function to format time for display
    function formatTime(time) {
      const [hours, minutes] = time.split(':');
      const period = hours >= 12 ? 'PM' : 'AM';
      const displayHours = hours % 12 || 12;
      return `${displayHours}:${minutes} ${period}`;
    }

    // Function to clear schedule form
    function clearScheduleForm() {
      document.getElementById('subjectCode').value = '';
      document.getElementById('subjectTitle').value = '';
      document.getElementById('section').value = '';
      document.getElementById('startTime').value = '';
      document.getElementById('endTime').value = '';
      document.getElementById('room').value = '';
      document.querySelectorAll('input[name="days"]').forEach(cb => cb.checked = false);
      document.getElementById('recurringPattern').value = 'weekly';
    }

    // Function to populate schedule form for editing
    function populateScheduleForm(schedule) {
      document.getElementById('subjectCode').value = schedule.subjectCode;
      document.getElementById('subjectTitle').value = schedule.subjectTitle;
      document.getElementById('section').value = schedule.section;
      document.getElementById('startTime').value = schedule.startTime;
      document.getElementById('endTime').value = schedule.endTime;
      document.getElementById('room').value = schedule.room;
      document.querySelectorAll('input[name="days"]').forEach(cb => {
        cb.checked = schedule.days.includes(cb.value);
      });
      document.getElementById('recurringPattern').value = schedule.recurring;
    }

    // Function to get form data
    function getScheduleFormData() {
      const selectedDays = Array.from(document.querySelectorAll('input[name="days"]:checked'))
        .map(cb => cb.value);

      return {
        subjectCode: document.getElementById('subjectCode').value,
        subjectTitle: document.getElementById('subjectTitle').value,
        section: document.getElementById('section').value,
        startTime: document.getElementById('startTime').value,
        endTime: document.getElementById('endTime').value,
        room: document.getElementById('room').value,
        days: selectedDays,
        recurring: document.getElementById('recurringPattern').value
      };
    }

    // Function to validate form data
    function validateScheduleForm(data) {
      if (!data.subjectCode || !data.subjectTitle || !data.section || 
          !data.startTime || !data.endTime || !data.room || !data.days.length) {
        alert('Please fill in all required fields and select at least one day.');
        return false;
      }
      return true;
    }

    // Function to render schedule table
    function renderScheduleTable() {
      if (!scheduleBody) return;
      
      scheduleBody.innerHTML = schedules.map(schedule => `
        <tr>
          <td>
            <div><strong>${schedule.subjectCode}</strong></div>
            <div class="muted small">${schedule.subjectTitle}</div>
          </td>
          <td>${schedule.section}</td>
          <td>
            <div class="mono">${formatTime(schedule.startTime)} - ${formatTime(schedule.endTime)}</div>
            <div class="muted small">${schedule.days.join(', ')}</div>
          </td>
          <td>${schedule.room}</td>
          <td><span class="badge green">${schedule.recurring}</span></td>
          <td>
            <div class="btn-group">
              <button class="btn secondary sm edit-schedule" data-id="${schedule.id}">Edit</button>
              <button class="btn destructive sm delete-schedule" data-id="${schedule.id}">Delete</button>
            </div>
          </td>
        </tr>
      `).join('');

      // Reattach event listeners
      attachScheduleEventListeners();
    }

    // Function to attach event listeners to schedule buttons
    function attachScheduleEventListeners() {
      // Edit schedule buttons
      document.querySelectorAll('.edit-schedule').forEach(btn => {
        btn.addEventListener('click', () => {
          const scheduleId = parseInt(btn.getAttribute('data-id'));
          const schedule = schedules.find(s => s.id === scheduleId);
          if (schedule) {
            currentEditId = scheduleId;
            document.getElementById('scheduleModalTitle').textContent = 'Edit Schedule';
            populateScheduleForm(schedule);
            scheduleModal.setAttribute('aria-hidden', 'false');
          }
        });
      });

      // Delete schedule buttons
      document.querySelectorAll('.delete-schedule').forEach(btn => {
        btn.addEventListener('click', () => {
          const scheduleId = parseInt(btn.getAttribute('data-id'));
          if (confirm('Are you sure you want to delete this schedule?')) {
            schedules = schedules.filter(s => s.id !== scheduleId);
            renderScheduleTable();
          }
        });
      });
    }

    // Track current schedule being edited
    let currentEditId = null;

    // Handle Add New Schedule button
    if (addScheduleBtn && scheduleModal) {
      addScheduleBtn.addEventListener('click', () => {
        currentEditId = null;
        document.getElementById('scheduleModalTitle').textContent = 'Add New Schedule';
        clearScheduleForm();
        scheduleModal.setAttribute('aria-hidden', 'false');
      });
    }

    // Handle Cancel button
    if (cancelScheduleBtn && scheduleModal) {
      cancelScheduleBtn.addEventListener('click', () => {
        scheduleModal.setAttribute('aria-hidden', 'true');
        currentEditId = null;
      });
    }

    // Handle Save button
    if (saveScheduleBtn && scheduleModal) {
      saveScheduleBtn.addEventListener('click', () => {
        const formData = getScheduleFormData();
        
        if (!validateScheduleForm(formData)) {
          return;
        }

        if (currentEditId === null) {
          // Add new schedule
          formData.id = schedules.length > 0 ? Math.max(...schedules.map(s => s.id)) + 1 : 1;
          schedules.push(formData);
        } else {
          // Update existing schedule
          const index = schedules.findIndex(s => s.id === currentEditId);
          if (index !== -1) {
            schedules[index] = { ...formData, id: currentEditId };
          }
        }

        renderScheduleTable();
        scheduleModal.setAttribute('aria-hidden', 'true');
        currentEditId = null;
      });
    }

    // Initial render of schedules
    renderScheduleTable();

    // Sample student statistics data
    const studentStats = [
      { id: 'S001', name: 'Alice Johnson', present: 15, absent: 1, late: 0 },
      { id: 'S002', name: 'Bob Williams', present: 12, absent: 2, late: 2 },
      { id: 'S003', name: 'Charlie Brown', present: 14, absent: 0, late: 2 }
    ];

    // Populate student statistics table
    const studentStatsBody = document.getElementById('studentStatsBody');
    if (studentStatsBody) {
      studentStats.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>
            <div><strong>${student.name}</strong></div>
            <div class="muted small">${student.id}</div>
          </td>
          <td>${student.present}</td>
          <td>${student.absent}</td>
          <td>${student.late}</td>
        `;
        studentStatsBody.appendChild(row);
      });
    }

    // Subject filter for analytics
    const subjectFilter = document.getElementById('subjectFilter');
    if (subjectFilter) {
      subjectFilter.addEventListener('change', () => {
        const subject = subjectFilter.value;
        // Update trend chart with new data
        if (subject === 'ITEL304') {
          window.renderLineChart(attendanceTrend, [92, 95, 91, 94, 96, 93, 95]);
        } else if (subject === 'ITST301') {
          window.renderLineChart(attendanceTrend, [95, 93, 97, 96, 94, 95, 92]);
        } else {
          window.renderLineChart(attendanceTrend, [95, 92, 97, 94, 96, 93, 95]);
        }
      });
    }

    // Export stats button
    const exportStatsBtn = document.getElementById('exportStatsBtn');
    if (exportStatsBtn) {
      exportStatsBtn.addEventListener('click', () => {
        const selectedSubject = subjectFilter.value;
        alert(`Generating attendance report for ${selectedSubject}...`);
        // In a real implementation, this would generate and download a report
      });
    }
  </script>
</body>
</html>
