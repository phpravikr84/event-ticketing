    <h1>Online Event Ticketing System</h1>
    <p>An online event ticketing system that allows users to create, manage, and attend events. The system handles event creation, ticket sales, attendee management, and payment integration.</p>

    <h2>Features</h2>
    <ul>
        <li><strong>User Authentication and Registration</strong>
            <ul>
                <li>Users can register and log in.</li>
                <li>Implemented user roles: 
                    <ul>
                        <li>Organizers</li>
                        <li>Attendees</li>
                    </ul>
                </li>
                <li>Personal information of users is encrypted.</li>
            </ul>
        </li>
        <li><strong>Event Creation and Management</strong>
            <ul>
                <li>Authenticated users (Organizers) can create, edit, and cancel events.</li>
                <li>Event details include:
                    <ul>
                        <li>Title</li>
                        <li>Description</li>
                        <li>Date</li>
                        <li>Location</li>
                        <li>Ticket Availability</li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><strong>Ticket Sales</strong>
            <ul>
                <li>Users (Attendees) can purchase event tickets.</li>
                <li>Multiple ticket types (e.g., Early Bird, Regular, VIP).</li>
                <li>Handle ticket availability and pricing.</li>
            </ul>
        </li>
        <li><strong>Attendee Management</strong>
            <ul>
                <li>Organizers can view a list of attendees for their events.</li>
                <li>Send email confirmations to attendees after ticket purchase.</li>
            </ul>
        </li>
        <li><strong>Payment Integration</strong>
            <ul>
                <li>Optional fake payment gateway integration for ticket purchases.</li>
                <li>Handle successful and failed transactions.</li>
            </ul>
        </li>
        <li><strong>Event Search and Discovery</strong>
            <ul>
                <li>Users can search for events based on:
                    <ul>
                        <li>Keywords</li>
                        <li>Location</li>
                        <li>Date</li>
                    </ul>
                </li>
                <li>Display upcoming events on the homepage.</li>
            </ul>
        </li>
        <li><strong>Event Details Page</strong>
            <ul>
                <li>Detailed information about an event, including ticket types and availability.</li>
                <li>Users can ask questions or leave comments.</li>
                <li>Export functionality to get event lists with details in an Excel sheet.</li>
            </ul>
        </li>
        <li><strong>Security and Authorization</strong>
            <ul>
                <li>Only event organizers can edit or cancel their events.</li>
                <li>Input validation to prevent malicious data.</li>
            </ul>
        </li>
        <li><strong>Performance Optimization</strong>
            <ul>
                <li>Optimized database queries using Eloquent and raw queries.</li>
                <li>Implemented caching for frequently accessed data (e.g., event lists).</li>
            </ul>
        </li>
    </ul>

    <h2>Installation Instructions</h2>
    <h3>Prerequisites</h3>
    <p>Before you begin, make sure you have the following installed:</p>
    <ul>
        <li><strong>PHP 8.1 or higher</strong></li>
        <li><strong>Composer</strong></li>
        <li><strong>Laravel 11</strong></li>
        <li><strong>MySQL or any preferred database</strong></li>
    </ul>

    <h3>Step 1: Clone the Repository</h3>
    <pre><code>git clone https://github.com/your-repository/online-event-ticketing.git
cd online-event-ticketing</code></pre>

    <h3>Step 2: Install Dependencies</h3>
    <pre><code>composer install</code></pre>

    <h3>Step 3: Environment Configuration</h3>
    <p>Copy the <code>.env.example</code> file to <code>.env</code> and configure your environment settings, including the database connection and mail service.</p>
    <pre><code>cp .env.example .env</code></pre>
    <p>Update your <code>.env</code> file with the correct settings for your environment, particularly the database and mailer configurations.</p>
    <pre><code>
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
    </code></pre>

    <h3>Step 4: Generate Application Key</h3>
    <pre><code>php artisan key:generate</code></pre>

    <h3>Step 5: Migrate the Database</h3>
    <pre><code>php artisan migrate</code></pre>

    <h3>Step 6: Seed the Database (Optional)</h3>
    <pre><code>php artisan db:seed</code></pre>

    <h2>User Roles & Dummy Credentials</h2>
    <p>This application uses three user types:</p>

    <h3>1. Admin</h3>
    <ul>
        <li><strong>Role</strong>: Administrator</li>
        <li><strong>Access</strong>: Full access to the system.</li>
        <li><strong>Credentials</strong>: 
            <ul>
                <li>Email: <code>admin@eventticketing.com</code></li>
                <li>Password: <code>admin1234</code></li>
            </ul>
        </li>
    </ul>

    <h3>2. Organizer</h3>
    <ul>
        <li><strong>Role</strong>: Event Organizer</li>
        <li><strong>Access</strong>: Can create, manage, and view events.</li>
        <li><strong>Credentials</strong>: 
            <ul>
                <li>Email: <code>organizer@eventticketing.com</code></li>
                <li>Password: <code>organizer1234</code></li>
            </ul>
        </li>
    </ul>

    <h3>3. Attendee</h3>
    <ul>
        <li><strong>Role</strong>: Event Attendee</li>
        <li><strong>Access</strong>: Can purchase tickets, view events, and participate in events.</li>
        <li><strong>Credentials</strong>: 
            <ul>
                <li>Email: <code>attendee@eventticketing.com</code></li>
                <li>Password: <code>attendee1234</code></li>
            </ul>
        </li>
    </ul>

    <h2>Application Workflow</h2>
    <ol>
        <li><strong>Authentication & Registration</strong>: Users can register by providing their name, email, and password. Admins have access to all functionality. Organizers can create and manage events, while attendees can view and purchase tickets.</li>
        <li><strong>Event Creation</strong>: Organizers can create events by filling out details such as title, description, location, date, and ticket availability.</li>
        <li><strong>Ticket Sales</strong>: Attendees can purchase tickets for available events. Different ticket types (Early Bird, VIP) are supported with different pricing.</li>
        <li><strong>Attendee Management</strong>: Organizers can view the list of attendees for their events and send email confirmations.</li>
        <li><strong>Payment Integration</strong>: Payments for ticket purchases are handled through a fake payment gateway.</li>
        <li><strong>Event Search</strong>: Attendees can search for events by keywords, date, or location.</li>
        <li><strong>Event Details Page</strong>: Each event has a detailed page showing all available ticket types and their pricing. Attendees can leave questions or comments.</li>
        <li><strong>Export Event List</strong>: Organizers can export event details into an Excel file.</li>
    </ol>

    <h2>Testing</h2>
    <p>The system includes automated tests for critical functionalities using <strong>PHPUnit</strong>. To run the tests, use the following command:</p>
    <pre><code>php artisan test</code></pre>

    <h2>Troubleshooting</h2>
    <ul>
        <li>If you encounter any issues during installation, make sure that your <code>.env</code> configuration is correct, especially for the database and mail settings.</li>
        <li>Ensure that the database has been migrated correctly.</li>
        <li>If the application is not sending emails, check the <code>MAIL_*</code> settings in your <code>.env</code> file.</li>
    </ul>

    <h2>License</h2>
    <p>This project is licensed under the MIT License - see the <a href="LICENSE">LICENSE</a> file for details.</p>
