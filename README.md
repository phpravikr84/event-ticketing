Online Event Ticketing System
An online event ticketing system that allows users to create, manage, and attend events. The system handles event creation, ticket sales, attendee management, and payment integration.

Features
User Authentication and Registration

Users can register and log in.
Implemented user roles:
Organizers
Attendees
Personal information of users is encrypted.
Event Creation and Management

Authenticated users (Organizers) can create, edit, and cancel events.
Event details include:
Title
Description
Date
Location
Ticket Availability
Ticket Sales

Users (Attendees) can purchase event tickets.
Multiple ticket types (e.g., Early Bird, Regular, VIP).
Handle ticket availability and pricing.
Attendee Management

Organizers can view a list of attendees for their events.
Send email confirmations to attendees after ticket purchase.
Payment Integration

Optional fake payment gateway integration for ticket purchases.
Handle successful and failed transactions.
Event Search and Discovery

Users can search for events based on:
Keywords
Location
Date
Display upcoming events on the homepage.
Event Details Page

Detailed information about an event, including ticket types and availability.
Users can ask questions or leave comments.
Export functionality to get event lists with details in an Excel sheet.
Security and Authorization

Only event organizers can edit or cancel their events.
Input validation to prevent malicious data.
Performance Optimization

Optimized database queries using Eloquent and raw queries.
Implemented caching for frequently accessed data (e.g., event lists).
Installation Instructions
Prerequisites
Before you begin, make sure you have the following installed:

PHP 8.2 or higher
Composer
Laravel 11
MySQL or any preferred database
Step 1: Clone the Repository
Clone the project repository to your local machine.

bash
-----
git clone https://github.com/your-repository/online-event-ticketing.git
cd online-event-ticketing
Step 2: Install Dependencies
Install all required PHP dependencies using Composer.

bash
----
composer install
Step 3: Environment Configuration
Copy the .env.example file to .env and configure your environment settings, including the database connection and mail service.

bash
-----
cp .env.example .env
Update your .env file with the correct settings for your environment, particularly the database and mailer configurations.

env
------
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_ticketing
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
Step 4: Generate Application Key
Generate the Laravel application key to secure sessions and other encrypted data.

--------
php artisan key:generate
Step 5: Migrate the Database
Run migrations to create the required database tables.

--------
php artisan migrate
Step 6: Seed the Database (Optional)
You can seed some dummy data for testing, including dummy users and events.

------
php artisan db:seed
User Roles & Dummy Credentials
This application uses three user types:

Admin

Role: Administrator
Access: Full access to the system.
Credentials:
Email: admin@eventticketing.com
Password: admin1234
Organizer

Role: Event Organizer
Access: Can create, manage, and view events.
Credentials:
Email: organizer@eventticketing.com
Password: organizer1234
Attendee

Role: Event Attendee
Access: Can purchase tickets, view events, and participate in events.
Credentials:
Email: attendee@eventticketing.com
Password: attendee1234
Application Workflow
Authentication & Registration:

Users can register by providing their name, email, and password.
Admins have access to all functionality.
Organizers can create and manage events, while attendees can view and purchase tickets.
Event Creation:

Organizers can create events by filling out details such as title, description, location, date, and ticket availability.
Ticket Sales:

Attendees can purchase tickets for available events. Different ticket types (Early Bird, VIP) are supported with different pricing.
Attendee Management:

Organizers can view the list of attendees for their events and send email confirmations.
Payment Integration:

Payments for ticket purchases are handled through a fake payment gateway.
Event Search:

Attendees can search for events by keywords, date, or location.
Event Details Page:

Each event has a detailed page showing all available ticket types and their pricing. Attendees can leave questions or comments.
Export Event List:

Organizers can export event details into an Excel file.
Testing
The system includes automated tests for critical functionalities using PHPUnit. To run the tests, use the following command:

----------
php artisan test
Troubleshooting
If you encounter any issues during installation, make sure that your .env configuration is correct, especially for the database and mail settings.
Ensure that the database has been migrated correctly.
If the application is not sending emails, check the MAIL_* settings in your .env file.
License
This project is licensed under the MIT License - see the LICENSE file for details.

End of Documentation
This README.md provides an overview of the Online Event Ticketing System, installation instructions, and user credentials for testing purposes. You can expand upon this with any additional features, installation steps, or configurations you may add in the future.