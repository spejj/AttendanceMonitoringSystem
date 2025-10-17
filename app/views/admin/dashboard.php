<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>AMS - Admin Dashboard</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <!-- Add Chart.js for analytics -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-soft">
  <div class="app-root">
    <header class="topbar">
      <nav class="container nav-flex">
        <div class="brand">AMS</div>

        <div class="nav-links hide-sm">
          <button data-view="admin" class="nav-btn active">Admin</button>
          <button data-view="instructor" class="nav-btn">Instructor</button>
          <button data-view="student-parent" class="nav-btn">Student/Parent</button>
        </div>

        <div class="nav-right">
          <button id="notificationBtn" class="btn secondary sm" aria-label="Notifications">
            <span id="notificationCount" class="badge red">3</span>
            📫
          </button>
          <button id="themeToggle" class="btn secondary sm" aria-label="Toggle theme">🌓</button>
          <span id="welcomeText" class="muted hide-md">Welcome, Admin</span>
          <button id="logoutBtn" class="btn secondary sm">Logout</button>
        </div>
      </nav>
    </header>

    <!-- Notification Center Modal -->
    <div class="modal" id="notificationModal" aria-hidden="true">
      <div class="modal-content card">
        <div class="flex-between">
          <h3>Notifications</h3>
          <button class="btn secondary sm" id="closeNotifications">×</button>
        </div>
        <div class="notification-list">
          <div class="notification unread">
            <strong>System Alert</strong>
            <p>3 instructors haven't updated attendance today</p>
            <div class="muted">2 minutes ago</div>
          </div>
          <div class="notification unread">
            <strong>Backup Complete</strong>
            <p>Daily backup completed successfully</p>
            <div class="muted">1 hour ago</div>
          </div>
          <div class="notification">
            <strong>New Registration</strong>
            <p>5 new user accounts pending approval</p>
            <div class="muted">3 hours ago</div>
          </div>
        </div>
      </div>
    </div>

    <main class="container page-content">
      <section class="space-y">
        <div class="flex-between">
          <div>
            <h2 class="page-title">Admin Dashboard</h2>
            <p class="muted">Today is Wednesday, October 17, 2025</p>
          </div>
          <button class="btn primary" id="createAnnouncementBtn">
            Create Announcement
          </button>
        </div>

        <!-- Quick Stats -->
        <div class="grid-stats">
          <div class="card stat">
            <div class="stat-icon blue">�</div>
            <div>
              <p class="muted">Users Online</p>
              <p class="stat-value">245</p>
              <p class="muted small">1,245 total users</p>
            </div>
          </div>

          <div class="card stat">
            <div class="stat-icon green">📚</div>
            <div>
              <p class="muted">Active Classes</p>
              <p class="stat-value">72</p>
              <p class="muted small">89% attendance rate</p>
            </div>
          </div>

          <div class="card stat">
            <div class="stat-icon amber">⚠️</div>
            <div>
              <p class="muted">Flagged Students</p>
              <p class="stat-value">12</p>
              <p class="muted small">Frequent absences</p>
            </div>
          </div>

          <div class="card stat">
            <div class="stat-icon red">�</div>
            <div>
              <p class="muted">Pending Actions</p>
              <p class="stat-value">8</p>
              <p class="muted small">Requires attention</p>
            </div>
          </div>
        </div>

        <!-- Real-time Attendance & Analytics -->
        <div class="grid-2">
          <div class="card">
            <div class="flex-between">
              <h3>Real-time Attendance</h3>
              <div class="btn-group">
                <button class="btn secondary sm active" data-period="today">Today</button>
                <button class="btn secondary sm" data-period="week">This Week</button>
                <button class="btn secondary sm" data-period="month">This Month</button>
              </div>
            </div>
            <canvas id="attendanceChart" height="200"></canvas>
            <div class="flex-between mt-6">
              <div>
                <div class="stat-value">452</div>
                <div class="muted">Students Present Now</div>
              </div>
              <button class="btn secondary sm" id="exportAttendanceBtn">Export Report</button>
            </div>
          </div>

          <div class="card">
            <div class="flex-between">
              <h3>Class Performance</h3>
              <select class="select sm" id="classFilter">
                <option value="all">All Classes</option>
                <option value="ITEL304">ITEL 304</option>
                <option value="ITST301">ITST 301</option>
              </select>
            </div>
            <canvas id="performanceChart" height="200"></canvas>
          </div>
        </div>

        <!-- User Management -->
        <div class="grid-3">
          <div class="card lg-col-2">
            <div class="flex-between">
              <h3>User Management</h3>
              <div class="btn-group">
                <button class="btn primary sm" id="addUserBtn">Add User</button>
                <button class="btn secondary sm" id="bulkApproveBtn">Bulk Approve</button>
                <button class="btn secondary sm" id="exportUsersBtn">Export</button>
              </div>
            </div>
            <div class="filters space-y mt-6">
              <div class="flex-between">
                <div class="btn-group">
                  <button class="btn secondary sm active" data-filter="all">All</button>
                  <button class="btn secondary sm" data-filter="pending">Pending</button>
                  <button class="btn secondary sm" data-filter="active">Active</button>
                  <button class="btn secondary sm" data-filter="inactive">Inactive</button>
                </div>
                <input type="search" class="input sm" placeholder="Search users..." id="userSearch">
              </div>
            </div>
            <div class="table-wrap">
              <table class="table">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="selectAllUsers"></th>
                    <th>User Name</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Last Active</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="userTable">
                  <tr>
                    <td><input type="checkbox" name="selectedUsers" value="1"></td>
                    <td>
                      <div><strong>John Doe</strong></div>
                      <div class="muted small">john.doe@email.com</div>
                    </td>
                    <td>Student</td>
                    <td><span class="badge amber">Pending</span></td>
                    <td>2025-10-17</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn secondary sm">Edit</button>
                        <button class="btn destructive sm">Delete</button>
                      </div>
                    </td>
                  </tr>
                  <!-- More users will be loaded dynamically -->
                </tbody>
              </table>
            </div>
          </div>

          <div class="stack">
            <div class="card">
              <h3>System Health</h3>
              <div class="space-y">
                <div class="flex-between">
                  <div class="muted">Last Backup</div>
                  <div>2 hours ago</div>
                </div>
                <div class="flex-between">
                  <div class="muted">Server Load</div>
                  <div class="highlight">32%</div>
                </div>
                <div class="flex-between">
                  <div class="muted">Storage Used</div>
                  <div>2.1 GB / 10 GB</div>
                </div>
                <button class="btn secondary w-full" id="backupNowBtn">Backup Now</button>
              </div>
            </div>

            <div class="card">
              <h3>Activity Feed</h3>
              <div class="feed-filters">
                <select class="select sm w-full">
                  <option value="all">All Activities</option>
                  <option value="attendance">Attendance</option>
                  <option value="grades">Grades</option>
                  <option value="users">User Account</option>
                  <option value="system">System</option>
                </select>
              </div>
              <ul class="feed">
                <li>
                  <strong>System Update</strong>
                  <p>Attendance records backed up</p>
                  <div class="muted">2 min ago</div>
                </li>
                <li>
                  <strong>New Registration</strong>
                  <p>Student account created: Maria G.</p>
                  <div class="muted">15 min ago</div>
                </li>
                <li>
                  <strong>Grade Update</strong>
                  <p>ITEL 304 grades posted by Prof. Smith</p>
                  <div class="muted">1 hour ago</div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- User Management Modal -->
  <div class="modal" id="userModal" aria-hidden="true">
    <div class="modal-content card">
      <h3 id="userModalTitle">Add New User</h3>
      <div class="space-y">
        <div>
          <label class="label">Full Name</label>
          <input type="text" id="userName" class="input" required>
        </div>
        <div>
          <label class="label">Email</label>
          <input type="email" id="userEmail" class="input" required>
        </div>
        <div>
          <label class="label">Role</label>
          <select id="userRole" class="select" required>
            <option value="student">Student</option>
            <option value="instructor">Instructor</option>
            <option value="parent">Parent</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div>
          <label class="label">Status</label>
          <select id="userStatus" class="select" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="pending">Pending</option>
          </select>
        </div>
        <div>
          <label class="label">Class Assignment</label>
          <select id="userClass" class="select" multiple>
            <option value="ITEL304">ITEL 304 - Web Systems</option>
            <option value="ITST301">ITST 301 - Information Assurance</option>
          </select>
        </div>
        <div class="flex-between">
          <button class="btn secondary" id="cancelUser">Cancel</button>
          <button class="btn primary" id="saveUser">Save User</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Announcement Modal -->
  <div class="modal" id="announcementModal" aria-hidden="true">
    <div class="modal-content card">
      <h3>Create Announcement</h3>
      <div class="space-y">
        <div>
          <label class="label">Title</label>
          <input type="text" id="announcementTitle" class="input" required>
        </div>
        <div>
          <label class="label">Message</label>
          <textarea id="announcementMessage" class="input" rows="4" required></textarea>
        </div>
        <div>
          <label class="label">Target Audience</label>
          <select id="announcementTarget" class="select" required>
            <option value="all">All Users</option>
            <option value="students">All Students</option>
            <option value="instructors">All Instructors</option>
            <option value="parents">All Parents</option>
            <option value="class">Specific Class</option>
          </select>
        </div>
        <div id="classSelector" style="display: none;">
          <label class="label">Select Class</label>
          <select id="announcementClass" class="select">
            <option value="ITEL304">ITEL 304 - Web Systems</option>
            <option value="ITST301">ITST 301 - Information Assurance</option>
          </select>
        </div>
        <div class="flex-between">
          <button class="btn secondary" id="cancelAnnouncement">Cancel</button>
          <button class="btn primary" id="saveAnnouncement">Post Announcement</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Chart.js and main scripts -->
  <script src="assets/js/charts.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/admin.js"></script>
</body>
</html>
