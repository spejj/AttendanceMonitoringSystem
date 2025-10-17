// main.js - simple navigation + interactivity for the static UI
(function () {
  // helpers
  const qs = (s, el = document) => el.querySelector(s);
  const qsa = (s, el = document) => Array.from(el.querySelectorAll(s));

  const roleFromStorage = () => localStorage.getItem('ams_role') || '';
  const nameFromStorage = () => localStorage.getItem('ams_name') || 'Dr. Anya F.';

  function applyHeaderInfo() {
    const welcomeEls = qsa('#welcomeText');
    welcomeEls.forEach(el => {
      const role = roleFromStorage();
      const name = nameFromStorage();
      // If the stored name indicates a parent, keep the detailed viewing text
      if (role.includes('Parent') || name.includes('Parent')) {
        el.textContent = 'Viewing as Parent of Alex Johnson';
        return;
      }

      // Map roles to exact welcome strings
      if (role.toLowerCase().includes('admin')) {
        el.textContent = 'Welcome, Admin';
        return;
      }

      if (role.toLowerCase().includes('instructor')) {
        el.textContent = 'Welcome, Instructor';
        return;
      }

      // Default: use provided name (fallback)
      el.textContent = `Welcome, ${name}`;
    });
  }

  // Hide UI elements that don't belong to the current role
  function enforceRoleUI() {
    const role = (roleFromStorage() || '').toLowerCase();
    // Map stored role to the data-view used in nav buttons
    const roleToView = {
      'admin': 'admin',
      'instructor': 'instructor',
      'student': 'student-parent',
      'student/parent': 'student-parent',
      'parent': 'student-parent'
    };
    const view = roleToView[role];
    if (!view) return; // nothing to enforce

    qsa('.nav-btn').forEach(btn => {
      const btnView = btn.getAttribute('data-view');
      if (!btnView) return;
      btn.style.display = (btnView === view) ? '' : 'none';
    });
  }

  // Handle login form submission
  const loginForm = qs('#loginForm');
  const loginError = qs('#loginError');

  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const username = qs('#username').value;
      const password = qs('#password').value;
      
      // Hide any previous error
      loginError.style.display = 'none';
      
      try {
        const response = await fetch('/Attendance-Monitoring-System-main/controllers/AuthController.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `action=login&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}&role=${encodeURIComponent(qs('#role').value)}`
        });
        
        const data = await response.json();
        
        if (data.success) {
          // Redirect to the appropriate dashboard
          window.location.href = data.redirect;
        } else {
          // Show error message
          loginError.textContent = data.message || 'Login failed';
          loginError.style.display = 'block';
        }
      } catch (error) {
        loginError.textContent = 'An error occurred. Please try again.';
        loginError.style.display = 'block';
      }
    });
  }

  // LOGIN form handling is now done in the handleLogin function above

  // Logout buttons
  qsa('#logoutBtn').forEach(btn => {
    btn.addEventListener('click', () => {
  localStorage.removeItem('ams_role');
  localStorage.removeItem('ams_name');
  window.location.href = 'index.php';
    });
  });

  // Header nav buttons to switch pages
  qsa('.nav-btn').forEach(btn => {
    btn.addEventListener('click', (ev) => {
      const view = ev.currentTarget.getAttribute('data-view');
  if (view === 'admin') window.location.href = 'admin-dashboard.php';
  if (view === 'instructor') window.location.href = 'instructor-dashboard.php';
  if (view === 'student-parent') window.location.href = 'student-parent.php';
    });
  });

  // Instructor: start attendance
  const startAttendance = qs('#startAttendanceBtn');
  if (startAttendance) {
    startAttendance.addEventListener('click', () => {
      window.location.href = 'take-attendance.php';
    });
  }

  // Take attendance logic
  const studentsInitial = [
    { id: 'S001', name: 'Alice Johnson', status: 'present', timeIn: '14:00', timeOut: '15:30', notes: '' },
    { id: 'S002', name: 'Bob Williams', status: 'absent', timeIn: '14:00', timeOut: '15:30', notes: '' },
    { id: 'S003', name: 'Charlie Brown', status: 'present', timeIn: '14:00', timeOut: '15:30', notes: '' },
    { id: 'S004', name: 'Diana Miller', status: 'late', timeIn: '14:10', timeOut: '15:30', notes: '' },
    { id: 'S005', name: 'Ethan Garcia', status: 'present', timeIn: '14:00', timeOut: '15:30', notes: '' },
    { id: 'S006', name: 'Fiona Rodriguez', status: 'absent', timeIn: '14:00', timeOut: '15:30', notes: '' },
  ];

  const attendanceBody = qs('#attendanceBody');
  const presentCountEl = qs('#presentCount');
  const absentCountEl = qs('#absentCount');

  function renderAttendance(students, filter = 'all') {
    if (!attendanceBody) return;
    attendanceBody.innerHTML = '';
    const list = students.filter(s => filter === 'all' ? true : s.status === filter);
    list.forEach((s, idx) => {
      const tr = document.createElement('tr');

      const studentCell = document.createElement('td');
      studentCell.innerHTML = `<div class="text-bold">${s.name}</div><div class="muted">${s.id}</div>`;

      const statusCell = document.createElement('td');
      const select = document.createElement('select');
      select.className = 'select';
      ['present','absent','late'].forEach(opt => {
        const o = document.createElement('option'); o.value = opt; o.textContent = opt.charAt(0).toUpperCase() + opt.slice(1);
        if (opt === s.status) o.selected = true;
        select.appendChild(o);
      });
      select.addEventListener('change', (e) => {
        s.status = e.target.value;
        updateSummary();
      });
      statusCell.appendChild(select);

      const timeInCell = document.createElement('td');
      const inInput = document.createElement('input'); inInput.type='time'; inInput.value = s.timeIn; inInput.className='input';
      inInput.addEventListener('change', e => s.timeIn = e.target.value);
      timeInCell.appendChild(inInput);

      const timeOutCell = document.createElement('td');
      const outInput = document.createElement('input'); outInput.type='time'; outInput.value = s.timeOut; outInput.className='input';
      outInput.addEventListener('change', e => s.timeOut = e.target.value);
      timeOutCell.appendChild(outInput);

      const notesCell = document.createElement('td');
      const notesInput = document.createElement('input'); notesInput.type='text'; notesInput.value = s.notes; notesInput.className='input';
      notesInput.addEventListener('change', e => s.notes = e.target.value);
      notesCell.appendChild(notesInput);

      tr.appendChild(studentCell);
      tr.appendChild(statusCell);
      tr.appendChild(timeInCell);
      tr.appendChild(timeOutCell);
      tr.appendChild(notesCell);
      attendanceBody.appendChild(tr);
    });
    updateSummary(students);
  }

  function updateSummary(list = studentsInitial) {
    const present = list.filter(s => s.status === 'present' || s.status === 'late').length;
    const absent = list.filter(s => s.status === 'absent').length;
    if (presentCountEl) presentCountEl.textContent = present;
    if (absentCountEl) absentCountEl.textContent = absent;
  }

  // initialize attendance page
  if (attendanceBody) {
    renderAttendance(studentsInitial);
    // filters
    qsa('.filter-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        qsa('.filter-btn').forEach(b => b.classList.remove('active'));
        e.currentTarget.classList.add('active');
        const filter = e.currentTarget.getAttribute('data-filter');
        renderAttendance(studentsInitial, filter);
      });
    });

    // mark all present
    const markAllBtn = qs('#markAllBtn');
    if (markAllBtn) {
      markAllBtn.addEventListener('click', () => {
        studentsInitial.forEach(s => s.status = 'present');
        renderAttendance(studentsInitial);
      });
    }

    // finalize & modal
    const finalizeBtn = qs('#finalizeBtn');
    const modal = qs('#finalModal');
    const closeModal = qs('#closeModal');
    if (finalizeBtn && modal) {
      finalizeBtn.addEventListener('click', () => {
        modal.setAttribute('aria-hidden', 'false');
      });
      if (closeModal) closeModal.addEventListener('click', () => modal.setAttribute('aria-hidden','true'));
    }

    // back to instructor
    const backBtn = qs('#backToInstructor');
  if (backBtn) backBtn.addEventListener('click', () => window.location.href = 'instructor-dashboard.php');
  }

  // Student/Parent: Handle attendance record filters
  const attendanceRecordsBody = qs('#attendanceRecordsBody');
  if (attendanceRecordsBody) {
    const records = Array.from(attendanceRecordsBody.querySelectorAll('tr')).map(row => ({
      element: row,
      status: row.querySelector('.badge').textContent.toLowerCase()
    }));

    // Handle filter clicks
    qsa('.filter-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const filter = e.currentTarget.getAttribute('data-filter');
        
        // Update active state
        qsa('.filter-btn').forEach(b => b.classList.remove('active'));
        e.currentTarget.classList.add('active');

        // Filter records
        records.forEach(({ element, status }) => {
          if (filter === 'all' || status.includes(filter)) {
            element.style.display = '';
          } else {
            element.style.display = 'none';
          }
        });
      });
    });
  }

  // apply header content on all pages
  applyHeaderInfo();
  // enforce role-based UI visibility (hide nav buttons and other role-specific elements)
  enforceRoleUI();

  // Try rendering placeholder charts if chart utilities are available.
  function tryRenderPlaceholders() {
    if (window.renderBarChart) {
      const bar = qs('#instructorBarChart');
      if (bar && (!bar.querySelector || !bar.querySelector('svg'))) {
        window.renderBarChart(bar, [{day:'Mon',val:95},{day:'Tue',val:98},{day:'Wed',val:97},{day:'Thu',val:88},{day:'Fri',val:92}]);
      }
    }
    if (window.renderLineChart) {
      const lc = qs('#trendLineChart');
      if (lc && (!lc.querySelector || !lc.querySelector('svg'))) {
        window.renderLineChart(lc, [92,95,98,97,95,93,90,97]);
      }
    }
  }

  // simple chart placeholders rendering hook (other file may augment)
  window.addEventListener('load', () => {
    // if chart containers present, call chart utilities from charts.js (if loaded)
    if (window.renderBarChart) {
      const bar = qs('#instructorBarChart');
      if (bar) window.renderBarChart(bar, [{day:'Mon',val:95},{day:'Tue',val:98},{day:'Wed',val:97},{day:'Thu',val:88},{day:'Fri',val:92}]);
    }
    if (window.renderLineChart) {
      const lc = qs('#trendLineChart');
      if (lc) window.renderLineChart(lc, [92,95,98,97,95,93,90,97]);
    }
    // ensure placeholders are rendered if they were missed earlier
    tryRenderPlaceholders();
  });
})();
