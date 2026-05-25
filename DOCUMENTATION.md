# Nyayaprabha Project Documentation

## Project Overview
Nyayaprabha is a Laravel-based complaint management and emergency alert application built with PHP 8.3 and Laravel 13.8. It supports user registration, OTP-based login and password recovery, complaint registration and tracking, emergency contact management, SOS alerts, and admin complaint workflow management.

## Key Features

### User Features
- User registration with email OTP verification
- Login with email and password
- Password reset using email OTP
- Profile management with editable contact and address details
- Upload profile images and gallery files
- Add, view, and remove emergency contacts
- Trigger emergency SOS alerts to contacts via email and SMS
- Register complaints with category, subcategory, and file attachment
- View complaint history and complaint details
- Access helpline information

### Admin Features
- Admin login and dashboard
- View key statistics: total users, active users, SOS alerts, pending complaints, resolved cases, emergency requests
- Manage users and view user login activity
- Add and delete helpline contacts
- Review complaint lists by status: not processed, in process, closed
- Update complaint status with remarks
- Send complaint status updates to users via email
- Manage categories, subcategories, and states

## Architecture & Code Structure

### Main Application Layers
- `app/Http/Controllers/` - Controller actions for users, admin, complaints, emergency contacts, SOS alerts, and category management
- `app/Mail/` - Mailable classes for OTP, SOS alerts, and complaint status updates
- `app/Models/` - Eloquent models for users, emergency contacts, gallery images, and other domain entities
- `resources/views/` - Blade templates for user and admin UIs
- `routes/web.php` - Web routes configuration for user and admin workflows
- `database/migrations/` - Database schema definitions for users, emergency contacts, SOS alerts, user gallery, and Laravel framework tables

## Important Routes

### User Routes
- `GET /users/login` - Login page
- `POST /users/login` - Authenticate user
- `POST /users/forgot-password` - Request password reset OTP
- `POST /users/verify-otp` - Verify OTP and reset password
- `GET /users/register` - Registration page
- `POST /users/register` - Start user registration and send OTP
- `POST /users/verify-registration-otp` - Confirm registration OTP
- `GET /users/dashboard` - User dashboard
- `GET /users/profile` - User profile
- `POST /users/profile` - Update profile and upload files
- `GET /users/change-password` - Change password page
- `POST /users/change-password` - Update password
- `GET /users/helplines` - Helpline directory
- `GET /users/emergency-contacts` - List emergency contacts
- `POST /users/emergency-contacts` - Add a new emergency contact
- `DELETE /users/emergency-contacts/{id}` - Delete emergency contact
- `POST /users/sos/trigger` - Trigger SOS alert
- `GET /users/register-complaint` - Complaint registration page
- `POST /users/register-complaint` - Submit a new complaint
- `POST /users/getsubcat` - Fetch subcategories by category
- `GET /users/complaint-history` - Complaint history
- `GET /users/complaint-details/{id}` - Complaint detail view
- `GET /users/logout` - Logout

### Admin Routes
- `GET /admin/login` - Admin login page
- `POST /admin/login` - Authenticate admin
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/logout` - Admin logout
- `GET /admin/manage-users` - User management
- `GET /admin/users/delete/{id}` - Delete user
- `GET /admin/user-logs` - View login activity
- `GET /admin/helplines` - Helpline management
- `POST /admin/helplines` - Add helpline entry
- `GET /admin/helplines/delete/{id}` - Delete helpline entry
- `GET /admin/notprocess-complaint` - View unprocessed complaints
- `GET /admin/inprocess-complaint` - View in-process complaints
- `GET /admin/closed-complaint` - View closed complaints
- `GET /admin/complaint-details/{id}` - Complaint management details
- `POST /admin/complaint-details/{id}` - Update complaint status
- `GET /admin/category` - Category management
- `POST /admin/category` - Add category
- `GET /admin/category/delete/{id}` - Delete category
- `GET /admin/subcategory` - Subcategory management
- `GET /admin/state` - View states

## Database Tables

The project uses the following primary tables:
- `users`
- `userlog`
- `tblcomplaints`
- `complaintremark`
- `category`
- `subcategory`
- `state`
- `emergency_contacts`
- `sos_alerts`
- `user_gallery`
- `tbl_helplines`
- `admin`

## Notifications & Messaging
- `app/Mail/SendOtpMail.php` - sends OTP emails for registration and password reset
- `app/Mail/StatusUpdateMail.php` - sends complaint status update emails
- `app/Mail/EmergencySosMail.php` - sends SOS alert emails to emergency contacts
- `app/Http/Controllers/SosController.php` - optionally sends SMS via Twilio if `TWILIO_SID`, `TWILIO_AUTH_TOKEN`, and `TWILIO_PHONE_NUMBER` are configured

## Setup Instructions

1. Install PHP dependencies:
   ```bash
   composer install
   ```
2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
3. Configure database and mail settings in `.env`
4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations:
   ```bash
   php artisan migrate
   ```
6. Optionally install front-end assets if you use the UI build:
   ```bash
   npm install
   npm run build
   ```
7. Start the development server:
   ```bash
   php artisan serve
   ```

## Environment Configuration
Key `.env` variables to configure:
- `DB_CONNECTION`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `MAIL_MAILER`
- `MAIL_HOST`
- `MAIL_PORT`
- `MAIL_USERNAME`
- `MAIL_PASSWORD`
- `MAIL_ENCRYPTION`
- `MAIL_FROM_ADDRESS`
- `MAIL_FROM_NAME`
- `TWILIO_SID`
- `TWILIO_AUTH_TOKEN`
- `TWILIO_PHONE_NUMBER`

## Notes & Recommendations
- The application uses legacy MD5 password validation for existing accounts and upgrades them to bcrypt on successful login.
- User registration stores temporary OTP data in the session until verification completes.
- SOS alerts require emergency contacts; otherwise the trigger returns an error message.
- Complaint files are stored in `public/complaintdocs`.

## Project Improvements to Consider
- Add middleware for authentication and role-based access control
- Replace direct `DB::table()` queries with Eloquent models for cleaner code
- Add unit and feature tests in the `tests/` folder
- Harden validation and error handling for production use
- Implement email queueing for improved performance

## Useful Files
- `routes/web.php` — web routes for user/admin workflows
- `app/Http/Controllers/` — main business logic controllers
- `resources/views/` — Blade views for user and admin interfaces
- `app/Mail/` — mail templates and notification classes
- `database/migrations/` — schema definitions
- `composer.json` — PHP dependencies and project scripts
