# Complaint Management System

The Complaint Management System is a PHP and MySQL web application designed to manage customer complaints from submission through resolution.

The application uses object-oriented PHP and an MVC-style structure to separate database operations, application processing, and the user interface. Different features are available based on whether the logged-in user is a Customer, Technician, or Administrator.

## Features

### Customer
- Create a customer account
- Log in securely using email and password
- Update profile information
- Submit new complaints
- Select a product or service
- Select a complaint type
- View submitted complaints
- Track complaint status
- View technician notes
- Log out securely

### Technician
- Log in securely using an employee User ID and password
- View assigned complaints
- View complaint details
- Add technician notes
- Mark complaints as resolved
- Add resolution notes
- Save the complaint resolution date
- Change password
- Log out securely

### Administrator
- Log in securely using an administrator account
- View all open complaints
- View unassigned open complaints
- View the technician assigned to an open complaint
- Assign and reassign complaints to technicians
- View customers and employees
- Update customer information
- Add new employee accounts
- Update employee information
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
3. An administrator reviews open and unassigned complaints.
4. The administrator assigns the complaint to a technician.
5. The technician views the assigned complaint.
6. The technician can add notes while working on the issue.
7. The customer can view updates and technician notes.
8. The technician adds resolution notes and marks the complaint as resolved.
9. The resolution date is saved and the complaint status is updated to Closed.

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
- Apache
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

The application includes several security features:

- HTTPS support
- Automatic HTTP to HTTPS redirection
- Password hashing using PHP password functions
- Password verification during login
- Session-based authentication
- Session ID regeneration after successful login
- Role-based authorization for Customers, Technicians, and Administrators
- Protected pages based on user role
- Complaint access restricted to the appropriate customer or assigned technician
- Prepared database statements
- Server-side input validation
- Output escaping when displaying user data
- Secure logout using session destruction

## Current Development

The core complaint management system is functional. Customers can submit and track complaints, technicians can work with assigned complaints, and administrators can manage users and complaint assignments.

Additional final development and testing will continue as the project progresses.

## Author

Princess Ellis
