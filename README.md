# Signup MVC

A simple **PHP Login & Signup Authentication System** built with PHP, MySQL/MariaDB, HTML, CSS, and JavaScript.

The project follows a lightweight **MVC-style structure** to separate database operations, validation/business logic, and view-related functionality.

## Features

* User registration
* User login
* Username validation
* Email validation
* Password strength validation
* Confirm-password validation
* Duplicate username detection
* Duplicate email detection
* Password hashing using PHP's `password_hash()`
* Secure password verification using `password_verify()`
* Session-based authentication
* Session ID regeneration
* Login and signup error handling
* Field-level validation messages
* Successful login/signup messages
* Preserving username and email values after failed signup
* Login/signup form switching
* Responsive glassmorphism-style UI

## Technologies

* **PHP 8.2+**
* **MySQL / MariaDB**
* **PDO**
* **HTML5**
* **CSS3**
* **JavaScript**
* **Apache / XAMPP**

## Project Structure

```text
signup-mvc/
│
├── css/
│   └── main.css
│
├── js/
│   └── app.js
│
├── includes/
│   │
│   ├── core/
│   │   ├── login.inc.php
│   │   ├── signup.inc.php
│   │   │
│   │   └── model/
│   │       ├── login/
│   │       │   ├── login_contr.inc.php
│   │       │   ├── login_model.inc.php
│   │       │   └── login_view.inc.php
│   │       │
│   │       └── signup/
│   │           ├── signup_contr.inc.php
│   │           ├── signup_model.inc.php
│   │           └── signup_view.inc.php
│   │
│   └── settings/
│       ├── config.inc.php
│       ├── dbh.inc.php
│       ├── session_regenerate.inc.php
│       └── tables_create.inc.php
│
└── index.php
```

## MVC-Style Architecture

The project uses a simplified MVC approach.

### Model

The model files handle database-related operations.

```text
includes/core/model/
├── login/
│   └── login_model.inc.php
│
└── signup/
    └── signup_model.inc.php
```

Examples include:

* Fetching users from the database
* Checking whether a username exists
* Checking whether an email exists
* Creating new users
* Storing password hashes

### Controller

The controller files handle validation and application logic.

```text
includes/core/model/
├── login/
│   └── login_contr.inc.php
│
└── signup/
    └── signup_contr.inc.php
```

They are responsible for things such as:

* Validating submitted data
* Checking login credentials
* Checking duplicate usernames/emails
* Creating validation error arrays
* Connecting model operations with the request handlers

### View

The view files contain functions responsible for preparing data for the user interface.

```text
includes/core/model/
├── login/
│   └── login_view.inc.php
│
└── signup/
    └── signup_view.inc.php
```

The main page is:

```text
index.php
```

It contains both the login and signup forms and uses the view functions to display errors and success messages.

## Authentication Flow

### Signup

```text
User submits signup form
        ↓
signup.inc.php
        ↓
Input validation
        ↓
Check username/email availability
        ↓
Hash password
        ↓
Insert user into database
        ↓
Store success message in session
        ↓
Redirect to index.php
```

### Login

```text
User submits login form
        ↓
login.inc.php
        ↓
Find username
        ↓
Verify password
        ↓
Create authenticated session
        ↓
Store user information in session
        ↓
Redirect to index.php
```

## Password Security

Passwords are not stored as plain text.

During signup, the password is hashed before being stored in the database.

During login, the submitted password is checked against the stored hash using PHP's password verification functionality.

This means the original password is never stored directly in the database.

## Database

The project uses a `users` table containing information such as:

```text
id
username
email
pwd
created_at
```

The username and email fields are unique.

The database/table setup is handled through:

```text
includes/settings/config.inc.php
includes/settings/tables_create.inc.php
```

## Requirements

Before running the project, install:

* XAMPP
* Apache
* MySQL or MariaDB
* PHP 8.2 or newer
* A web browser

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/OrpanAp/signup-mvc.git
```

### 2. Move the project into XAMPP

Place the project inside:

```text
C:\xampp\htdocs\
```

The final path should look like:

```text
C:\xampp\htdocs\signup-mvc
```

### 3. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 4. Configure the database

Open:

```text
includes/settings/config.inc.php
```

Configure the database connection according to your local environment.

For a default local XAMPP installation, the configuration may use:

```php
$dbhost = "localhost";
$dbname = "user_list";
$dbuser = "root";
$dbpass = "";
```

Do not use these credentials for a production environment.

### 5. Open the application

Open:

```text
http://localhost/signup-mvc/
```

The login/signup page should appear.

## Validation

The signup system validates:

* Username is required
* Username minimum length
* Username maximum length
* Email format
* Password length
* Uppercase letter
* Lowercase letter
* Number
* Special character
* Confirm password
* Password matching
* Duplicate username
* Duplicate email

Login validates:

* Username
* Password
* Username existence
* Password correctness

## Sessions

Session configuration is handled through:

```text
includes/settings/session_regenerate.inc.php
```

The project uses:

* Cookie-only sessions
* Strict session mode
* HTTP-only session cookies
* SameSite cookie configuration
* Periodic session ID regeneration

## Important Security Note

This project is intended primarily as a learning project.

Before deploying it to production, additional security considerations should be addressed, including:

* Production database credentials
* HTTPS configuration
* CSRF protection
* Login rate limiting
* Brute-force protection
* Secure production session configuration
* More comprehensive output/input handling
* Production error handling
* Environment-based configuration

Never commit real passwords, API keys, database credentials, or other secrets to a public GitHub repository.

## Learning Goals

This project is designed to practice:

* PHP fundamentals
* Form handling
* POST requests
* Server-side validation
* PDO and prepared statements
* MySQL/MariaDB
* Password hashing
* Session management
* MVC-style organization
* Separation of concerns
* HTML/CSS/JavaScript integration
* Git and GitHub

## License

This project currently does not specify a license.
