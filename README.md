# Online Event Ticketing System

An online event ticketing system that allows users to create, manage, and attend events. The system handles event creation, ticket sales, attendee management, and payment integration.

## Features

- **User Authentication and Registration**
  - Users can register and log in.
  - Implemented user roles: 
    - Organizers
    - Attendees
  - Personal information of users is encrypted.
  
- **Event Creation and Management**
  - Authenticated users (Organizers) can create, edit, and cancel events.
  - Event details include:
    - Title
    - Description
    - Date
    - Location
    - Ticket Availability
  
- **Ticket Sales**
  - Users (Attendees) can purchase event tickets.
  - Multiple ticket types (e.g., Early Bird, Regular, VIP).
  - Handle ticket availability and pricing.
  
- **Attendee Management**
  - Organizers can view a list of attendees for their events.
  - Send email confirmations to attendees after ticket purchase.
  
- **Payment Integration**
  - Optional fake payment gateway integration for ticket purchases.
  - Handle successful and failed transactions.
  
- **Event Search and Discovery**
  - Users can search for events based on:
    - Keywords
    - Location
    - Date
  - Display upcoming events on the homepage.
  
- **Event Details Page**
  - Detailed information about an event, including ticket types and availability.
  - Users can ask questions or leave comments.
  - Export functionality to get event lists with details in an Excel sheet.
  
- **Security and Authorization**
  - Only event organizers can edit or cancel their events.
  - Input validation to prevent malicious data.
  
- **Performance Optimization**
  - Optimized database queries using Eloquent and raw queries.
  - Implemented caching for frequently accessed data (e.g., event lists).

## Installation Instructions

### Prerequisites
Before you begin, make sure you have the following installed:
- **PHP 8.1 or higher**
- **Composer**
- **Laravel 11**
- **MySQL or any preferred database**

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-repository/online-event-ticketing.git
cd online-event-ticketing
