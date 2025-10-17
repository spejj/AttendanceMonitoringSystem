<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>AMS - Take Attendance</title>
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
          <span id="welcomeText" class="muted hide-md">Welcome, Student/Parent</span>
          <button id="logoutBtn" class="btn secondary sm">Logout</button>
        </div>
      </nav>
    </header>

    <main class="container page-content">
      <div class="space-y">
        <div>
          <button id="backToInstructor" class="link-back">← Back to Dashboard</button>
          <h2 class="page-title">ITEL 304 - Attendance for Oct 15, 2025</h2>
          <p class="muted">2:00 PM Session</p>
        </div>

        <div class="card">
          <div class="flex-between mb-4">
            <div class="btn-group">
              <button id="markAllBtn" class="btn secondary">Mark All Present</button>
              <button class="btn secondary filter-btn" data-filter="all">All</button>
              <button class="btn secondary filter-btn" data-filter="present">Present</button>
              <button class="btn secondary filter-btn" data-filter="late">Late</button>
              <button class="btn secondary filter-btn" data-filter="absent">Absent</button>
            </div>
            <button id="finalizeBtn" class="btn primary">FINALIZE & NOTIFY PARENTS</button>
          </div>

          <div class="table-wrap">
            <table class="table" id="attendanceTable">
              <thead>
                <tr><th>Student</th><th>Status</th><th>Time In</th><th>Time Out</th><th>Notes</th></tr>
              </thead>
              <tbody id="attendanceBody">
                <!-- populated by JS -->
              </tbody>
            </table>
          </div>

          <div class="text-right mt-4 muted">
            Summary: <strong id="presentCount">0</strong> Present, <strong id="absentCount">0</strong> Absent
          </div>
        </div>
      </div>
    </main>

    <!-- Modal -->
    <div id="finalModal" class="modal" aria-hidden="true">
      <div class="modal-content card">
        <h3 class="page-title">Finalized!</h3>
        <p class="muted">Attendance for ITEL 304 has been recorded and parents have been notified.</p>
        <div class="modal-actions">
          <button id="closeModal" class="btn primary">OK</button>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/main.js"></script>
</body>
</html>
