# bookings-system
Project Overview
This project is built using Laravel 12 and styled with Tailwind CSS. Below is a summary of the key features and functionality implemented:

Database Info
Database Name: bookings_system

Ensure your .env has the correct DB settings:

DB_DATABASE=bookings_system
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

Run npm install 
Run npm run dev
Run composer install

✅ Features Implemented
Breeze Authentication (Blade version):
Laravel Breeze was used for basic authentication, utilizing Blade templates.

User Fields Extension:
First Name and Last Name fields were added to the default users table using a custom migration.

Email Verification:

User email verification is enforced.

Unverified users cannot log in.

To enable the email functionality, you must configure your IMAP email address and password in the .env file.

Email Verification:

Users must verify their email before they can log in.

Email functionality uses IMAP, and you need to create an IMAP App Password.

In your .env file, configure the following:

MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-imap-app-password

No other SMTP configuration changes are needed.


Booking Module:

A booking form with options (Full Day, Half Day, Custom).

Listing and filtering of bookings are implemented.

Validations and overlap restrictions are properly handled.

Requirement Compliance:
All requirements specified in the shared email have been fully implemented.
