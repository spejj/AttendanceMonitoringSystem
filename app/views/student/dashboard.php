<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>AMS - Student/Parent</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body class="bg-gray-soft">
  <div class="app-root">
    <header class="topbar">
      <nav class="container nav-flex">
        <div class="brand">AMS</div>
        <div class="nav-links hide-sm">
          <button data-view="admin" class="nav-btn">Admin</button>
          <button data-view="instructor" class="nav-btn">Instructor</button>
          <button data-view="student-parent" class="nav-btn active">Student/Parent</button>
        </div>
        <div class="nav-right">
          <span id="welcomeText" class="muted hide-md">Viewing as Parent of Alex Johnson</span>
          <button id="logoutBtn" class="btn secondary sm">Logout</button>
        </div>
      </nav>
    </header>

    <main class="container page-content">
      <div class="space-y">
        <div>
          <h2 class="page-title">Student Portal</h2>
          <p class="muted">Viewing as Parent of Alex Johnson</p>
        </div>

        <div class="grid-2">
          <div class="card center">
            <p class="muted">Current Attendance</p>
            <p class="big-number green">97%</p>
            <p class="muted">3 absences this semester</p>
          </div>

          <div class="card center">
            <p class="muted">Overall GPA</p>
            <p class="big-number blue">3.85</p>
            <p class="muted">Excellent Standing</p>
          </div>
        </div>

        <div class="grid-3">
          <div class="card lg-col-2">
            <h3>8-Week Attendance Trend</h3>
            <div class="chart-box" id="trendLineChart"></div>
          </div>

          <div class="stack">
            <div class="card">
              <h3>Grades Summary</h3>
              <details class="group"><summary>ITEL 304 <span class="blue">A-</span></summary>
                <div class="muted small mt-2">Midterm: 92%<br/>Assignment 1: 95%</div>
              </details>
              <details class="group"><summary>ITST 301 <span class="green">A</span></summary></details>
            </div>

            <div class="card">
              <h3>Recent Attendance Timeline</h3>
              <ul class="timeline">
                <li class="timeline-item green">
                  <div class="row-between">
                    <strong>ITEL 304</strong>
                    <span class="badge green">PRESENT</span>
                  </div>
                  <div class="muted">Oct 14, 2025</div>
                  <div class="muted">Time In: 2:01 PM, Time Out: 3:28 PM</div>
                </li>

                <li class="timeline-item red">
                  <div class="row-between">
                    <strong>ITST 301</strong>
                    <span class="badge red">ABSENT</span>
                  </div>
                  <div class="muted">Oct 13, 2025</div>
                  <div class="muted">Reason: Unexcused</div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- New Attendance Records Section -->
        <div class="card">
          <div class="flex-between mb-4">
            <h3>Detailed Attendance Records</h3>
            <div class="btn-group">
              <button class="btn secondary filter-btn active" data-filter="all">All</button>
              <button class="btn secondary filter-btn" data-filter="present">Present</button>
              <button class="btn secondary filter-btn" data-filter="late">Late</button>
              <button class="btn secondary filter-btn" data-filter="absent">Absent</button>
            </div>
          </div>

          <div class="table-wrap">
            <table class="table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Class</th>
                  <th>Status</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                  <th>Notes</th>
                </tr>
              </thead>
              <tbody id="attendanceRecordsBody">
                <tr>
                  <td>Oct 15, 2025</td>
                  <td>
                    <div class="text-bold">ITEL 304</div>
                    <div class="muted">Section B</div>
                  </td>
                  <td><span class="badge green">Present</span></td>
                  <td>2:00 PM</td>
                  <td>3:30 PM</td>
                  <td>-</td>
                </tr>
                <tr>
                  <td>Oct 14, 2025</td>
                  <td>
                    <div class="text-bold">ITST 301</div>
                    <div class="muted">Section A</div>
                  </td>
                  <td><span class="badge amber">Late</span></td>
                  <td>2:10 PM</td>
                  <td>3:30 PM</td>
                  <td>Traffic delay</td>
                </tr>
                <tr>
                  <td>Oct 13, 2025</td>
                  <td>
                    <div class="text-bold">ITEP 309</div>
                    <div class="muted">Section B</div>
                  </td>
                  <td><span class="badge red">Absent</span></td>
                  <td>-</td>
                  <td>-</td>
                  <td>Medical appointment</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="text-right mt-4 space-x">
            <span class="muted">Term Summary:</span>
            <span class="badge green sm">Present: 85%</span>
            <span class="badge amber sm">Late: 10%</span>
            <span class="badge red sm">Absent: 5%</span>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script src="assets/js/charts.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
