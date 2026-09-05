# Project Structure

## Project Scope

This is a simple product purchase application.

Products are managed from the admin panel at `/admin`. The admin panel should include product management, order management, user management, payment collection records, and manual order tracking.

Users must log in before buying a product. User login is currently email based. User details such as name, phone, email, and address should be stored. Each user should have purchase history available in the system.

## Admin

Admin routes should live under `/admin`.

The admin can manage:

- Products
- Users
- Orders
- Payments collected from users
- Manual order tracking status

## Users

User login should be handled from `/login`.

The system should store:

- Name
- Phone
- Email
- Address
- Purchase history

## Frontend Pages

The reference HTML pages are stored in `ref/html pages/`.

First, convert these HTML pages into Laravel-compatible Blade structure by splitting them into layouts, partials, and pages. Do not redesign the pages during this step.

After the HTML pages are split into Blade files, the Blade pages can be improved and connected to dynamic Laravel data later.

## Blade Splitting Guideline

Use this structure when converting the reference HTML pages:

- `resources/views/layouts/` for main page layouts
- `resources/views/partials/` for shared header, footer, navigation, and reusable sections
- `resources/views/pages/` for frontend pages
- `resources/views/admin/` for admin panel pages
- `resources/views/auth/` for login-related pages

## Important Rule

The `ref/` folder is for reference only. It should not be used directly by production Laravel routes, controllers, or views.
