// admin.js - Admin dashboard functionality
(function() {
    // Theme Management
    const root = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const THEME_KEY = 'ams_theme';

    function setTheme(isDark) {
        if (isDark) {
            root.style.setProperty('--bg', '#1a1a1a');
            root.style.setProperty('--card', '#242424');
            root.style.setProperty('--muted', '#888888');
            document.body.classList.add('dark-mode');
        } else {
            root.style.setProperty('--bg', '#F8F9FA');
            root.style.setProperty('--card', '#ffffff');
            root.style.setProperty('--muted', '#6b7280');
            document.body.classList.remove('dark-mode');
        }
        localStorage.setItem(THEME_KEY, isDark ? 'dark' : 'light');
    }

    if (themeToggle) {
        const savedTheme = localStorage.getItem(THEME_KEY);
        if (savedTheme === 'dark') setTheme(true);

        themeToggle.addEventListener('click', () => {
            const isDark = document.body.classList.contains('dark-mode');
            setTheme(!isDark);
        });
    }

    // Notification Center
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationModal = document.getElementById('notificationModal');
    const closeNotifications = document.getElementById('closeNotifications');

    if (notificationBtn && notificationModal) {
        notificationBtn.addEventListener('click', () => {
            notificationModal.setAttribute('aria-hidden', 'false');
        });

        closeNotifications.addEventListener('click', () => {
            notificationModal.setAttribute('aria-hidden', 'true');
        });
    }

    // User Management
    const userModal = document.getElementById('userModal');
    const addUserBtn = document.getElementById('addUserBtn');
    const cancelUserBtn = document.getElementById('cancelUser');
    const saveUserBtn = document.getElementById('saveUser');
    const selectAllUsers = document.getElementById('selectAllUsers');
    const userTable = document.getElementById('userTable');

    // Handle bulk selection
    if (selectAllUsers && userTable) {
        selectAllUsers.addEventListener('change', (e) => {
            const checkboxes = userTable.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(cb => cb.checked = e.target.checked);
        });
    }

    // User modal handlers
    if (addUserBtn && userModal) {
        addUserBtn.addEventListener('click', () => {
            document.getElementById('userModalTitle').textContent = 'Add New User';
            clearUserForm();
            userModal.setAttribute('aria-hidden', 'false');
        });
    }

    if (cancelUserBtn) {
        cancelUserBtn.addEventListener('click', () => {
            userModal.setAttribute('aria-hidden', 'true');
        });
    }

    if (saveUserBtn) {
        saveUserBtn.addEventListener('click', () => {
            const userData = {
                name: document.getElementById('userName').value,
                email: document.getElementById('userEmail').value,
                role: document.getElementById('userRole').value,
                status: document.getElementById('userStatus').value,
                classes: Array.from(document.getElementById('userClass').selectedOptions).map(opt => opt.value)
            };

            // Validate form
            if (!userData.name || !userData.email) {
                alert('Please fill in all required fields');
                return;
            }

            // TODO: Send to backend API
            console.log('Saving user:', userData);
            userModal.setAttribute('aria-hidden', 'true');
        });
    }

    // Announcement Management
    const announcementModal = document.getElementById('announcementModal');
    const createAnnouncementBtn = document.getElementById('createAnnouncementBtn');
    const cancelAnnouncementBtn = document.getElementById('cancelAnnouncement');
    const saveAnnouncementBtn = document.getElementById('saveAnnouncement');
    const announcementTarget = document.getElementById('announcementTarget');
    const classSelector = document.getElementById('classSelector');

    if (createAnnouncementBtn && announcementModal) {
        createAnnouncementBtn.addEventListener('click', () => {
            announcementModal.setAttribute('aria-hidden', 'false');
        });
    }

    if (cancelAnnouncementBtn) {
        cancelAnnouncementBtn.addEventListener('click', () => {
            announcementModal.setAttribute('aria-hidden', 'true');
        });
    }

    if (announcementTarget) {
        announcementTarget.addEventListener('change', (e) => {
            classSelector.style.display = e.target.value === 'class' ? 'block' : 'none';
        });
    }

    if (saveAnnouncementBtn) {
        saveAnnouncementBtn.addEventListener('click', () => {
            const announcement = {
                title: document.getElementById('announcementTitle').value,
                message: document.getElementById('announcementMessage').value,
                target: announcementTarget.value,
                class: announcementTarget.value === 'class' ? document.getElementById('announcementClass').value : null
            };

            if (!announcement.title || !announcement.message) {
                alert('Please fill in all required fields');
                return;
            }

            // TODO: Send to backend API
            console.log('Saving announcement:', announcement);
            announcementModal.setAttribute('aria-hidden', 'true');
        });
    }

    // Charts
    function initializeCharts() {
        // Attendance Chart
        const attendanceCtx = document.getElementById('attendanceChart');
        if (attendanceCtx) {
            new Chart(attendanceCtx, {
                type: 'line',
                data: {
                    labels: ['8 AM', '9 AM', '10 AM', '11 AM', '12 PM', '1 PM', '2 PM'],
                    datasets: [{
                        label: 'Students Present',
                        data: [320, 380, 420, 450, 400, 420, 452],
                        borderColor: '#3b82f6',
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Performance Chart
        const performanceCtx = document.getElementById('performanceChart');
        if (performanceCtx) {
            new Chart(performanceCtx, {
                type: 'bar',
                data: {
                    labels: ['Present', 'Late', 'Absent', 'Excused'],
                    datasets: [{
                        data: [75, 12, 8, 5],
                        backgroundColor: [
                            '#10b981',
                            '#f59e0b',
                            '#ef4444',
                            '#6b7280'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => value + '%'
                            }
                        }
                    }
                }
            });
        }
    }

    // Initialize charts on load
    window.addEventListener('load', initializeCharts);

    // Export functionality
    const exportAttendanceBtn = document.getElementById('exportAttendanceBtn');
    if (exportAttendanceBtn) {
        exportAttendanceBtn.addEventListener('click', () => {
            // TODO: Implement actual export
            alert('Generating attendance report...');
        });
    }

    const exportUsersBtn = document.getElementById('exportUsersBtn');
    if (exportUsersBtn) {
        exportUsersBtn.addEventListener('click', () => {
            // TODO: Implement actual export
            alert('Exporting user data...');
        });
    }

    // System maintenance
    const backupNowBtn = document.getElementById('backupNowBtn');
    if (backupNowBtn) {
        backupNowBtn.addEventListener('click', () => {
            backupNowBtn.disabled = true;
            backupNowBtn.textContent = 'Backing up...';
            // TODO: Implement actual backup
            setTimeout(() => {
                backupNowBtn.disabled = false;
                backupNowBtn.textContent = 'Backup Now';
                alert('Backup completed successfully');
            }, 2000);
        });
    }

    // Utility functions
    function clearUserForm() {
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        document.getElementById('userRole').value = 'student';
        document.getElementById('userStatus').value = 'active';
        document.getElementById('userClass').selectedIndex = -1;
    }
})();