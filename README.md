# Complaint Management System

## Project Overview

The Complaint Management System is a PHP and MySQL web application designed to help customers submit and track complaints while allowing technicians and administrators to manage customer issues.

This project is being developed as part of the Advanced Server-Side Scripting with PHP course. The application will be developed in multiple phases throughout the course.

## Phase #2 – Database and Application Framework

During Phase #2, the foundation of the Complaint Management System was created. This phase focused on developing the database structure, establishing the PHP application framework, and confirming communication between the application and MySQL database.

## Features Completed

- Created the MySQL `complaint_management` database
- Created the initial database tables
- Established relationships between complaint-related data
- Added five products/services
- Added three complaint types
- Created a PHP database connection class
- Confirmed successful connection between PHP and MySQL
- Created an MVC-style project folder structure
- Created the customer registration interface
- Created the account login interface
- Added reusable input validation support
- Created and styled the main welcome page
- Exported the database to an SQL file

## Database Tables

The database currently contains the following tables:

- `customers`
- `employees`
- `products`
- `complaint_types`
- `complaints`
- `technician_notes`
- `complaint_images`

These tables provide the foundation for storing customer accounts, employee accounts, products and services, complaint categories, complaints, technician notes, and uploaded complaint images.

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

ComplaintManagementSystem/

    controller/
    css/
        styles.css
    includes/
        validation.php
    model/
        database.php
    sql/
        complaint_management.sql
    view/
        home.php
        login.php
        register.php
    index.php

## Database Setup

1. Start Apache and MySQL using XAMPP.
2. Open phpMyAdmin.
3. Create or import the `complaint_management` database.
4. Import the `complaint_management.sql` file located in the `sql` folder.
5. Verify that all required tables were created.
6. Open the project through localhost.

## Running the Application

Place the project folder inside the XAMPP `htdocs` directory.

The application can then be accessed through:

    http://localhost/ComplaintManagementSystem/

Make sure both Apache and MySQL are running before opening the application.

## Current Status

Phase #2 establishes the database and basic application framework. The application currently connects successfully to the MySQL database and includes the initial customer registration and login interfaces.

Future phases will expand the system with database-backed PHP objects, CRUD operations, complaint management functionality, authentication and authorization, technician functions, administrator functions, image/file support, and final testing.

## Author

Princess Ellis

Advanced Server-Side Scripting with PHP  
ECPI University

## License

This project is for educational purposes.
