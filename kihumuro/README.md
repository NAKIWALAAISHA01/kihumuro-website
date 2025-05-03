# Kihumuro Hospital Website

A modern, responsive website for Kihumuro Hospital, featuring both frontend and backend components. The website provides information about the hospital's services, allows patients to book appointments, and includes a secure user management system.

## Features

- Modern, responsive design
- User authentication system (login/register)
- Appointment booking system
- Contact form
- Admin dashboard
- Patient dashboard
- Doctor profiles
- Department information
- Mobile-friendly interface

## Technologies Used

- Frontend:
  - HTML5
  - CSS3
  - JavaScript (ES6+)
  - Font Awesome Icons
  - Google Fonts

- Backend:
  - PHP 7.4+
  - MySQL/MariaDB
  - PDO for database operations

## Prerequisites

- Web server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/kihumuro-hospital.git
```

2. Create a MySQL database and import the database structure:
```bash
mysql -u your_username -p < database.sql
```

3. Configure the database connection:
   - Open `config/database.php`
   - Update the database credentials:
     ```php
     private $host = "localhost";
     private $db_name = "kihumuro_hospital";
     private $username = "your_username";
     private $password = "your_password";
     ```

4. Set up the web server:
   - Point your web server's document root to the project directory
   - Ensure the web server has write permissions for any upload directories
   - Configure URL rewriting if needed

5. Access the website:
   - Open your web browser
   - Navigate to `http://localhost/kihumuro-hospital` (or your configured domain)

## Default Login Credentials

- Admin:
  - Email: admin@kihumurohospital.com
  - Password: admin123

## Directory Structure

```
kihumuro-hospital/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   └── images/
├── config/
│   └── database.php
├── includes/
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── process_contact.php
├── process_appointment.php
├── logout.php
├── database.sql
└── README.md
```

## Security Features

- Password hashing using PHP's password_hash()
- Prepared statements for all database queries
- Input validation and sanitization
- Session management
- CSRF protection
- XSS prevention

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@kihumurohospital.com or create an issue in the repository.

## Acknowledgments

- Font Awesome for icons
- Google Fonts for typography
- All contributors who have helped with the project 