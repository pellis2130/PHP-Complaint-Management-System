# Complaint Management System

The Complaint Management System is a PHP and MySQL web application designed to make handling customer complaints organized, secure, and easy to manage from the initial submission through final resolution.

The system uses object-oriented PHP and an MVC-style structure to separate database operations, application processing, and the user interface. Customers, Technicians, and Administrators each have their own access and functionality within the system.

## Features

### Customer
- Create a customer account
- Log in securely using email and password
- Update profile information
- Submit new complaints
- Select a product or service
- Select a complaint type
- Add a detailed complaint description
- Upload an image with a complaint
- View previously submitted complaints
- Track complaint status
- View technician notes and updates
- Send messages to the assigned technician
- Receive responses from the assigned technician
- Log out securely

### Technician
- Log in securely using an employee User ID and password
- View assigned complaints
- View complete complaint details
- View customer-uploaded complaint images
- Communicate directly with customers through complaint messages
- Add technician notes
- Track work performed on a complaint
- Mark complaints as resolved
- Add required resolution notes
- Automatically save the complaint resolution date
- Change password
- Log out securely

### Administrator
- Log in securely using an administrator account
- View all open complaints
- View unassigned open complaints
- View the technician assigned to each complaint
- Assign and reassign complaints to technicians
- View technician workload counts
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

The system supports the complaint process from beginning to end:

1. A customer submits a complaint with the appropriate product/service, complaint type, description, and optional image.
2. The complaint is stored with an Open status.
3. An administrator can review open and unassigned complaints.
4. The administrator assigns the complaint to a technician.
5. The assigned technician can review the complaint details and uploaded image.
6. The technician can add notes while investigating the complaint.
7. The customer and technician can communicate directly through complaint messages.
8. The customer can continue monitoring the complaint and viewing technician updates.
9. Once the issue is handled, the technician enters the required resolution notes.
10. The complaint is marked Closed and the resolution date is automatically recorded.

## Complaint Communication

Customers and assigned technicians can communicate directly from within a complaint.

Messages remain connected to the complaint so conversations about an issue can be viewed alongside its other information. Technician notes are kept separate from customer communication, allowing technicians to maintain complaint notes while still communicating directly with the customer.

## Image Uploads

Customers can attach an image when submitting a complaint.

Uploaded images are:

- Validated before being accepted
- Limited by file type
- Limited by file size
- Given a generated file name
- Stored in the complaint uploads directory
- Connected to the correct complaint in the database
- Available for the assigned technician to view

## Database

The application uses a MySQL database named:

`complaint_management`

The database contains related tables for:

- Customers
- Employees
- Products / Services
- Complaint Types
- Complaints
- Complaint Images
- Technician Notes
- Complaint Messages

These relationships keep customer information, complaint details, technician activity, uploaded images, and communication connected throughout the complaint process.

## Technologies Used

- PHP
- MySQL
- MySQLi
- HTML
- CSS
- Apache
- XAMPP
- phpMyAdmin
- Visual Studio Code
- Git
- GitHub

## Project Structure

The application is organized using an MVC-style structure:

- `model/` - PHP objects and database operations
- `view/` - Customer, Technician, and Administrator interfaces
- `controller/` - Processes requests and application actions
- `css/` - Application styling
- `includes/` - Reusable validation and application functions
- `sql/` - Database SQL files
- `uploads/` - Stores uploaded complaint images

## Security

The Complaint Management System includes multiple security and validation features:

- HTTPS support
- Automatic HTTP to HTTPS redirection
- Password hashing using PHP password functions
- Password verification during login
- Password complexity requirements
- Session-based authentication
- Session ID regeneration after successful login
- Role-based authorization
- Protected Customer, Technician, and Administrator pages
- Customer access restricted to their own complaints
- Technician access restricted to assigned complaints
- Prepared database statements
- Server-side input validation
- Email validation
- Phone number validation
- ZIP code validation
- Field length restrictions
- Image type and size validation
- Output escaping when displaying user data
- Secure logout using session destruction

## Complaint Management

Complaint types and products/services can be managed by Administrators. Items that are removed from future use can be kept safely within the database when needed so existing complaints continue to maintain their original information.

Technician workload tracking also allows Administrators to see the number of open complaints currently assigned to each technician before making new assignments.

## Status

The Complaint Management System is fully functional with Customer, Technician, and Administrator access.

The system supports account management, complaint submission, image uploads, complaint assignment, technician workload tracking, technician notes, customer-technician communication, complaint resolution, status tracking, and administrative management.

## Author

Princess Ellis
