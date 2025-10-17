# Attendance Monitoring System

A web-based attendance monitoring system for educational institutions, built with PHP and MySQL.

## Features

- **User Management**
  - Multiple user roles (Admin, Instructor, Student/Parent)
  - Secure authentication and authorization
  - User registration with approval system

- **Attendance Management**
  - Real-time attendance tracking
  - Multiple class/section support
  - Attendance reports and analytics

- **Dashboard & Analytics**
  - Role-specific dashboards
  - Visual attendance statistics
  - Performance trends

- **Announcements**
  - Role-based announcements
  - Target specific classes or groups

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- XAMPP/WAMP/LAMP stack (recommended)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/spejj/AttendanceMonitoringSystem.git
   ```

2. Move to your web server directory:
   ```bash
   mv AttendanceMonitoringSystem /path/to/your/www/folder
   ```

3. Create a MySQL database named 'attendance_db'

4. Run the database setup script:
   - Navigate to `http://localhost/AttendanceMonitoringSystem/database_setup.php`
   - This will create all necessary tables and a default admin account

5. Default admin credentials:
   - Username: admin
   - Password: admin123

## Project Structure

```
AttendanceMonitoringSystem/
├── app/
│   ├── config/         # Configuration files
│   ├── models/         # Database models
│   ├── controllers/    # Application controllers
│   └── views/         # View templates
├── assets/
│   ├── css/           # Stylesheets
│   └── js/            # JavaScript files
├── public/            # Publicly accessible files
└── database_setup.php # Database initialization
```

## Security Features

- Password hashing using PHP's password_hash()
- PDO prepared statements for SQL injection prevention
- Role-based access control
- Session management
- Input validation and sanitization

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, please open an issue in the GitHub repository or contact the maintainers.
