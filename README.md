# DisasterPrep

## Overview
DisasterPrep is a web-based platform designed to educate communities on disaster management and preparedness. Developed as a college assignment, this project aims to provide users with essential tools and resources to enhance their readiness for disasters such as floods, earthquakes, and wildfires. The platform includes interactive features like quizzes, customizable emergency plans, and a feedback system, all secured with user authentication.

## Features
- **Homepage**: Offers disaster preparedness tips with tabs for general advice, flood, earthquake, and wildfire safety.
- **User Authentication**: Login and signup functionality with profile management.
- **Quiz**: A quiz feature to test users' knowledge, manageable via an admin panel.
- **Curriculum**: Allows users to create and download personalized disaster management plans.
- **Contact Form**: Collects user feedback, stored in a MySQL database.
- **Admin Panel**: Enables administrators to add and manage quiz questions.

## Tech Stack
- **Frontend**: HTML, Tailwind CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (managed with XAMPP and phpMyAdmin)
- **Development Environment**: XAMPP for local server and database setup

## Installation & Setup
1. **Prerequisites**:
   - Install XAMPP (https://www.apachefriends.org/index.html) to run Apache and MySQL locally.
   - Ensure PHP and MySQL are enabled in XAMPP.

2. **Clone the Repository**:
   - Download or clone this project to your local machine: `git clone <your-repo-url>` (replace with your GitHub repo URL).

3. **Database Setup**:
   - Start XAMPP and open phpMyAdmin (http://localhost/phpmyadmin).
   - Create a new database named `disasterprep_db`.
   - Import the SQL file `database.sql` (included in the repo) to set up the `users`, `contact`, and `quiz_questions` tables.

4. **Configure the Project**:
   - Place the project folder (e.g., `DisasterPrep`) in the `htdocs` directory of XAMPP (e.g., `C:\xampp\htdocs\DisasterPrep`).
   - Update the database connection in `includes/db.php` with your MySQL credentials (default: `root`, no password unless changed).

5. **Run the Project**:
   - Start the Apache and MySQL modules in XAMPP.
   - Access the site at `http://localhost/DisasterPrep/index.php`.
   - Register a user or log in with an admin account (set `is_admin = 1` in the `users` table for admin access).

## Usage
- Navigate the site using the header menu after logging in.
- Take the quiz or create a curriculum plan as a regular user.
- Admins can access the admin panel to add quiz questions.
- Submit feedback via the contact page to test the database integration.

## Contributing
This project was developed as an educational exercise. Contributions are welcome! Please fork the repository and submit pull requests for enhancements.

## License
This project is for educational purposes only and is not licensed for commercial use.

## Acknowledgments
- Inspired by the need for community disaster preparedness.
- Built with guidance from online resources and personal learning efforts.