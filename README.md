# 🔐 PHP Signup & Login MVC

A lightweight **user authentication system built with PHP, MySQL, PDO, HTML, CSS, and JavaScript**, structured around the **Model–View–Controller (MVC) pattern**.

The project provides a complete signup and login workflow with:

* User registration
* Login authentication
* Server-side validation
* Duplicate username/email detection
* Strong password validation
* Password hashing with bcrypt
* PDO prepared statements
* Session-based authentication
* Session ID regeneration
* Persistent validation feedback
* Signup input preservation after validation errors
* Login/signup form switching
* Responsive modern UI
* Automatic database and table creation

The project is designed as a practical learning project for understanding how authentication can be built in **plain PHP without relying on a full PHP framework**.

---

## 📸 Project Overview

The application presents both authentication forms through a single interface:

```text
┌─────────────────────────────────────┐
│                                     │
│             LOGIN / SIGNUP          │
│                                     │
│       ┌─────────────────────┐       │
│       │       LOGIN         │       │
│       │                     │       │
│       │ Username            │       │
│       │ Password            │       │
│       │                     │       │
│       │       Login         │       │
│       │                     │       │
│       │ Don't have account? │       │
│       │      Sign Up        │       │
│       └─────────────────────┘       │
│                                     │
└─────────────────────────────────────┘
```

The login and signup forms exist on the same page, while JavaScript controls which form is visible. The active form is also preserved through the PHP session when a server-side validation error occurs.

---

# ✨ Features

## 👤 User Registration

Users can create an account using:

* Username
* Email
* Password
* Password confirmation

The signup request is processed by the signup controller, validated, checked against the database for duplicate credentials, and finally stored as a new user.

---

## 🔑 User Login

Existing users can authenticate using:

* Username
* Password

The login system:

1. Validates the submitted username.
2. Validates the password format.
3. Retrieves the user from MySQL.
4. Checks whether the username exists.
5. Verifies the submitted password against the stored password hash.
6. Creates the authenticated session.
7. Regenerates the session ID.
8. Stores the authenticated user's information in the session.

---

# 🛡️ Validation

The application performs **server-side validation** before creating an account or authenticating a user.

## Username

The username:

* Is required.
* Must contain at least 3 characters.
* Cannot exceed 30 characters.

```text
Minimum: 3 characters
Maximum: 30 characters
```

## Email

The email:

* Is required.
* Must pass PHP's `FILTER_VALIDATE_EMAIL` validation.

## Password

Signup passwords must:

* Be at least 8 characters.
* Contain at least one uppercase letter.
* Contain at least one lowercase letter.
* Contain at least one number.
* Contain at least one special character.

## Password Confirmation

The confirmation password:

* Is required.
* Must match the original password.

These rules are implemented in the signup controller/validation layer.

The login validation applies the username requirements and the same password-format requirements before authentication proceeds.

---

# 🔐 Password Security

Passwords are **never stored as plain text**.

During registration, the project uses PHP's:

```php
password_hash()
```

with:

```php
PASSWORD_BCRYPT
```

and a configurable bcrypt cost factor.

The current configuration uses:

```php
$pwd_cost = 12;
```

During login, the submitted password is checked using:

```php
password_verify()
```

against the stored bcrypt hash.

---

# 🗄️ Database

The application uses:

**MySQL / MariaDB**

through PHP's:

**PDO — PHP Data Objects**

The default development configuration is:

```text
Host:     localhost
Database: user_list
Username: root
Password: empty
Charset:  utf8mb4
```

> The default credentials are intended for a local development environment such as XAMPP. Production credentials should never be hard-coded.

---

# 🏗️ Database Schema

The application automatically creates a `users` table if it does not already exist.

```text
users
├── id
├── username
├── email
├── pwd
└── created_at
```

The actual schema is:

```sql
CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    pwd VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
```

### Constraints

| Column       | Type         | Constraint                  |
| ------------ | ------------ | --------------------------- |
| `id`         | INT          | Primary key, auto increment |
| `username`   | VARCHAR(30)  | Required, unique            |
| `email`      | VARCHAR(100) | Required, unique            |
| `pwd`        | VARCHAR(255) | Required, bcrypt hash       |
| `created_at` | DATETIME     | Automatically generated     |

---

# ⚙️ Automatic Database Initialization

One of the project's useful features is that you do **not** need to manually create the database or `users` table.

When the database connection is initialized, the application:

```text
Start Application
       │
       ▼
Load Configuration
       │
       ▼
Connect to MySQL Server
       │
       ▼
Does user_list exist?
       │
   ┌───┴───┐
   │       │
  NO      YES
   │       │
   ▼       │
Create DB  │
   │       │
   └───┬───┘
       ▼
Does users table exist?
       │
   ┌───┴───┐
   │       │
  NO      YES
   │       │
   ▼       │
Create     │
table      │
   │       │
   └───┬───┘
       ▼
Application continues
```

This logic is implemented in `dbh.inc.php` and `tables_create.inc.php`.

---

# 🧱 Architecture

The project follows a lightweight **MVC-style separation of responsibilities**.

```text
                    Browser
                       │
                       ▼
                  index.php
                       │
            ┌──────────┴──────────┐
            │                     │
            ▼                     ▼
      Login Request          Signup Request
            │                     │
            ▼                     ▼
      login.inc.php         signup.inc.php
            │                     │
            ▼                     ▼
       Controller              Controller
            │                     │
            ▼                     ▼
       Model Layer             Model Layer
            │                     │
            └──────────┬──────────┘
                       ▼
                     PDO
                       │
                       ▼
                    MySQL
```

The application separates:

### Model

Responsible for database operations.

```text
includes/core/model/
```

### Controller

Responsible for:

* Receiving POST data
* Running validation
* Calling model functions
* Managing errors
* Managing session messages
* Redirecting the request

### View

Responsible for:

* HTML
* Form presentation
* Displaying errors
* Displaying success messages
* Preserving signup input

The main presentation layer is `index.php`, while dedicated view helper files retrieve temporary session messages and format field errors.

---

# 📁 Project Structure

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
│   │       │
│   │       ├── login/
│   │       │   ├── login_model.inc.php
│   │       │   ├── login_contr.inc.php
│   │       │   └── login_view.inc.php
│   │       │
│   │       └── signup/
│   │           ├── signup_model.inc.php
│   │           ├── signup_contr.inc.php
│   │           └── signup_view.inc.php
│   │
│   └── settings/
│       ├── config.inc.php
│       ├── dbh.inc.php
│       ├── tables_create.inc.php
│       └── session_regenerate.inc.php
│
├── index.php
└── README.md
```

---

# 🧩 File Responsibilities

## `index.php`

The primary application view.

It:

* Starts the session through the session configuration.
* Loads signup and login view helpers.
* Retrieves validation errors.
* Retrieves success messages.
* Retrieves previously submitted signup values.
* Determines the active form.
* Renders the login form.
* Renders the signup form.
* Loads the frontend JavaScript.

The forms submit to:

```text
includes/core/login.inc.php
includes/core/signup.inc.php
```

---

# 📝 Signup Controller

```text
includes/core/signup.inc.php
```

The signup controller handles POST requests.

The flow is:

```text
POST / Signup
       │
       ▼
Read username/email/password
       │
       ▼
Validate input
       │
       ▼
Check username exists
       │
       ▼
Check email exists
       │
       ▼
Are there errors?
   ┌───┴───┐
  YES      NO
   │        │
   ▼        ▼
Store      Hash password
errors     │
in session │
   │        ▼
   │       INSERT user
   │        │
   │        ▼
   │      Success
   │
   └───────┬────────
           ▼
      Redirect to
       index.php
```

The **Post/Redirect/Get pattern** is used so the user is redirected back to `index.php` after processing the form instead of rendering the response directly from the POST request.

---

# 🔐 Login Controller

```text
includes/core/login.inc.php
```

The login controller follows this flow:

```text
POST / Login
      │
      ▼
Read username/password
      │
      ▼
Validate input
      │
      ▼
Query user by username
      │
      ▼
Username exists?
   ┌──┴──┐
  NO    YES
   │      │
   ▼      ▼
Error   password_verify()
          │
       ┌──┴──┐
      NO     YES
       │      │
       ▼      ▼
     Error   Login
             success
               │
               ▼
        Create authenticated
             session
               │
               ▼
          Redirect
```

---

# 🗃️ Model Layer

The model layer contains database-specific operations.

## Signup Model

```text
signup_model.inc.php
```

Provides functions for:

```php
get_username()
get_email()
set_user()
```

User creation uses a prepared SQL statement:

```sql
INSERT INTO users
(username, email, pwd)
VALUES
(:username, :email, :pwd)
```

The password is hashed before it reaches the database.

---

## Login Model

```text
login_model.inc.php
```

Provides:

```php
get_username()
```

It retrieves the complete user record using a prepared statement:

```sql
SELECT * FROM users
WHERE username = :username
```

---

# 🧪 Prepared Statements

Database queries use PDO prepared statements and named parameters.

Example:

```php
$stmt = $pdo->prepare($query);
$stmt->bindParam(":username", $username);
$stmt->execute();
```

This keeps user-provided values separate from the SQL statement instead of directly concatenating them into SQL queries.

---

# 🔄 Session Management

Session handling is implemented in:

```text
includes/settings/session_regenerate.inc.php
```

The project configures PHP sessions with:

```php
session.use_only_cookies = 1
session.use_strict_mode = 1
```

The session cookie is configured with:

```text
HttpOnly: true
SameSite: Lax
Secure: controlled by HTTPS configuration
```

---

# 🔄 Session ID Regeneration

The application periodically regenerates the session ID.

The configured interval is:

```php
$id_regen_interval = 60 * 30;
```

which equals:

```text
30 minutes
```

When the user is authenticated, the session ID is regenerated when:

* No previous regeneration timestamp exists, or
* The previous regeneration occurred at least 30 minutes ago.

This is an important part of the application's session-security design.

---

# 🔁 Validation Error Persistence

The application uses the session as temporary storage between POST processing and the redirected GET request.

For example:

```text
Signup
  │
  ▼
Validation fails
  │
  ▼
Errors → $_SESSION
  │
  ▼
Redirect
  │
  ▼
index.php
  │
  ▼
Read session errors
  │
  ▼
Display errors
  │
  ▼
Remove errors from session
```

The same pattern is used for successful signup/login messages.

---

# 📝 Preserving Signup Input

If signup validation fails, the project preserves:

```text
Username
Email
```

The password fields are intentionally not preserved.

The values are temporarily stored in:

```php
$_SESSION['signup_data']
```

and retrieved on the next request.

The HTML output is escaped using:

```php
htmlspecialchars()
```

before being inserted into the input fields.

---

# 🎨 Frontend

The frontend consists of:

```text
HTML
CSS
JavaScript
```

No frontend framework is required.

---

# 🖥️ CSS Design

The interface uses a modern dark/glassmorphism-inspired design.

The stylesheet includes:

* Responsive layout
* Gradient background
* Animated background orbs
* Glass-style authentication cards
* Blur effects
* Form transitions
* Input focus animations
* Error-state styling
* Animated buttons
* Responsive typography

The main stylesheet is:

```text
css/main.css
```

---

# 🔄 Login / Signup Toggle

The two forms are displayed on the same page.

JavaScript controls their visibility by adding/removing the:

```text
active
```

CSS class.

### Signup button

```javascript
loginForm.classList.remove("active");
signupForm.classList.add("active");
```

### Login button

```javascript
signupForm.classList.remove("active");
loginForm.classList.add("active");
```

This functionality is contained in:

```text
js/app.js
```

---

# 🛠️ Technologies Used

## Backend

| Technology          | Purpose                                     |
| ------------------- | ------------------------------------------- |
| **PHP**             | Server-side application logic               |
| **PDO**             | Database abstraction                        |
| **MySQL / MariaDB** | Relational database                         |
| **PHP Sessions**    | Authentication state and temporary messages |

## Frontend

| Technology     | Purpose                      |
| -------------- | ---------------------------- |
| **HTML5**      | Application structure        |
| **CSS3**       | Responsive UI and animations |
| **JavaScript** | Login/signup form switching  |

## Security APIs

| PHP Feature               | Purpose                 |
| ------------------------- | ----------------------- |
| `password_hash()`         | Secure password hashing |
| `password_verify()`       | Password verification   |
| `PDO::prepare()`          | Prepared SQL statements |
| `htmlspecialchars()`      | HTML output escaping    |
| `session_regenerate_id()` | Session ID rotation     |
| `session.use_strict_mode` | Session security        |

---

# 💻 Requirements

For local development, you need:

* PHP 8.x recommended
* MySQL or MariaDB
* Apache or another PHP-compatible web server
* PHP PDO extension
* PHP PDO MySQL driver
* A modern web browser

### Recommended local environment

The project works well with:

```text
XAMPP
├── Apache
├── MySQL / MariaDB
└── PHP
```

---

# 🚀 Installation

## 1. Clone the repository

```bash
git clone https://github.com/OrpanAp/signup-mvc.git
```

Move into the project:

```bash
cd signup-mvc
```

---

## 2. Place the project in your web server directory

For XAMPP on Windows:

```text
C:\xampp\htdocs\signup-mvc
```

Your final structure should look like:

```text
C:\xampp\htdocs\signup-mvc
```

---

## 3. Start XAMPP

Open XAMPP Control Panel and start:

```text
Apache
MySQL
```

---

## 4. Configure the database

The default configuration is:

```php
$dbhost = "localhost";
$dbname = "user_list";
$dbuser = "root";
$dbpass = "";
```

For a default XAMPP installation, this can work without manually creating the database.

The application will check whether:

```text
user_list
```

exists and create it if necessary.

It will then check for:

```text
users
```

and create the table when necessary.

---

## 5. Open the application

Visit:

```text
http://localhost/signup-mvc/
```

You should see the Login / Signup interface.

---

# 🧪 Testing the Application

## Test Signup

Try:

```text
Username: alex
Email: alex@example.com
Password: Password@123
Confirm: Password@123
```

A successful registration should:

1. Validate the input.
2. Check username availability.
3. Check email availability.
4. Hash the password.
5. Insert the user into MySQL.
6. Store a success message in the session.
7. Redirect back to the main page.

---

## Test Validation

Try an invalid username:

```text
ab
```

The application should report:

```text
Username must be at least 3 characters.
```

Try a weak password:

```text
password
```

The application should report the missing password requirements.

---

## Test Duplicate Username

Register a username that already exists.

The application should report:

```text
Username already exists.
```

The duplicate check is performed against the database before user creation.

---

## Test Duplicate Email

Register an email that already exists.

The application should report:

```text
Email already exists.
```

The database also enforces uniqueness on the `email` column.

---

## Test Login

Use the username and password of an existing account.

The application retrieves the user record and verifies the password using:

```php
password_verify()
```

---

# 🔐 Security Considerations

The project already demonstrates several good security practices:

### Password hashing

Passwords are stored using bcrypt rather than plain text.

### Prepared statements

PDO prepared statements are used for user queries.

### Session security

Sessions use:

```text
HttpOnly
SameSite=Lax
Strict session mode
Periodic session ID regeneration
```

### Output escaping

User-provided values displayed in HTML are escaped using:

```php
htmlspecialchars()
```

---

# ⚠️ Production Configuration

The current configuration is intended for local development.

Before deploying this project publicly, change the database configuration so credentials are not hard-coded.

Current development configuration:

```php
$dbhost = "localhost";
$dbname = "user_list";
$dbuser = "root";
$dbpass = "";
```

For production, use environment variables or another secure configuration mechanism.

---

## HTTPS

The project currently contains:

```php
$https_enabled = false;
```

This controls the `Secure` attribute of the session cookie.

For an HTTPS production deployment, this should be configured appropriately.

---

# 📚 What This Project Demonstrates

This project is useful for learning how a PHP authentication system works internally without using Laravel or another full-stack framework.

It demonstrates:

* PHP request handling
* POST forms
* MVC architecture
* Separation of concerns
* PHP sessions
* Authentication
* Password hashing
* Password verification
* PDO
* Prepared statements
* MySQL
* Database creation
* Table creation
* CRUD fundamentals
* Server-side validation
* Error handling
* Post/Redirect/Get
* Temporary session messages
* HTML escaping
* JavaScript DOM manipulation
* CSS animations
* Responsive design
* Session ID regeneration

---

# 🔮 Possible Future Improvements

Possible extensions for the project include:

* Protected user dashboard
* Logout endpoint
* User profile management
* Password change
* Forgot-password workflow
* Email verification
* Remember-me functionality
* CSRF protection
* Rate limiting for login attempts
* Account lockout after repeated failures
* Environment-variable configuration
* Centralized configuration management
* Better production error handling
* Database migrations
* Automated tests
* PHPUnit integration
* Composer-based project configuration
* Role/permission system
* Login activity logging

---

# 📌 Current Scope

The current repository focuses specifically on:

```text
User Registration
        +
User Login
        +
Validation
        +
Password Security
        +
Session Management
        +
Responsive Authentication UI
```

It is intentionally lightweight and does not depend on a PHP framework.

---

# 👨‍💻 Author

**OrpanAp**

GitHub:

https://github.com/OrpanAp

Repository:

https://github.com/OrpanAp/signup-mvc

---

# 📄 License

No explicit open-source license is currently included in the repository.

If you intend to distribute or reuse the project publicly, consider adding a license such as the MIT License.

---

## ⭐ Project Summary

**Signup MVC** is a lightweight PHP authentication project demonstrating how a registration and login system can be designed from scratch using MVC principles.

The application combines:

```text
PHP
 │
 ├── MVC-style architecture
 │
 ├── PDO
 │
 ├── MySQL
 │
 ├── Sessions
 │
 └── Password hashing
       │
       ▼
HTML + CSS + JavaScript
```

The result is a small but complete authentication foundation that can be extended into a larger PHP application.
