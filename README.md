# Complaint Management System

The Complaint Management System is a PHP and MySQL web application designed to manage customer complaints from submission through resolution.

The application uses object-oriented PHP and an MVC-style structure to separate database operations, application processing, and the user interface.

## Features

### Customer
- Create a customer account
- Log in securely
- Update profile information
- Submit new complaints
- Select a product or service
- Select a complaint type
- View submitted complaints
- Track complaint status
- Log out securely

### Technician
- Log in using an employee account
- View assigned complaints
- View complaint details
- Add technician notes
- Mark complaints as resolved
- Add resolution notes
- Change password
- Log out securely

### Administrator
- Log in using an administrator account
- View open complaints
- Assign complaints to technicians
- View customers and employees
- Manage products and services
- Add and remove products/services
- Manage complaint types
- Add and remove complaint types
- Change password
- Log out securely

## Complaint Process

The application supports the complaint process from beginning to end:

1. A customer submits a complaint.
2. The complaint is stored with an Open status.
3. An administrator reviews the complaint.
4. The administrator assigns the complaint to a technician.
5. The technician views the assigned complaint.
6. The technician can add notes while working on the issue.
7. The technician adds resolution notes and marks the complaint as resolved.
8. The complaint status is updated to Closed.

## Database

The application uses a MySQL database named:

`complaint_management`

The database contains tables for:

- Customers
- Employees
- Products / Services
- Complaint Types
- Complaints
- Complaint Images
- Technician Notes

## Technologies Used

- PHP
- MySQL
- HTML
- CSS
- XAMPP
- phpMyAdmin
- Visual Studio Code
- Git
- GitHub

## Project Structure

The project is organized using an MVC-style structure:

- `model/` - PHP objects and database operations
- `view/` - User interface pages
- `controller/` - Processes user requests and application actions
- `css/` - Application styling
- `includes/` - Reusable application functions
- `sql/` - Database SQL files

## Security

The application includes:

- Password hashing
- Password verification
- Session-based authentication
- Role-based access for customers, technicians, and administrators
- Prepared database statements
- Input validation
- Protected customer, technician, and administrator pages

## Author

Princess Ellis
