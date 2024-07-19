# CodeIgniter 4 Admin App

This project is based on CodeIgniter 4, a PHP full-stack web framework that is light, fast, flexible, and secure. It is designed to provide a solid foundation for developing web applications quickly and efficiently.

## Features

The CodeIgniter 4 Admin App includes the following key features:

- **User Management**: Easily manage user accounts, including creation, update, and deletion functionalities. Implement role-based access control to ensure users have the appropriate permissions.

- **Authentication and Authorization**: Secure your application with built-in authentication and authorization features. Includes support for session management and secure password handling.

- **Database Management**: Utilize CodeIgniter's migration and seeder functionalities to manage your database schema and initial data setup efficiently.

- **API Support**: Build and consume APIs with the provided structure for API development, including request validation and response formatting.

- **Performance Optimization**: Leverage CodeIgniter's performance features, including caching and efficient database querying, to ensure your application runs smoothly.

- **Security**: Benefit from CodeIgniter 4's security practices, including input validation, CSRF protection, and XSS filtering.

### TODO:

- **Content Management**: Manage your application's content with an intuitive interface for creating, updating, and deleting articles, posts, or any custom content types.

- **File Upload and Management**: Implement file upload functionality, including image and document management, with easy-to-use interfaces.

- **Theme and Layout**: Customize the look and feel of your application with theming support. Modify layouts, views, and assets to match your branding.

- **Localization and Internationalization**: Make your application globally accessible with built-in support for multiple languages and locales.

## Server Requirements

- PHP version 7.4 or higher.
- Extensions: intl, mbstring, json (enabled by default), mysqlnd (if using MySQL), libcurl (if using HTTP\CURLRequest library).

> **Warning:** PHP 7.4 and PHP 8.0 have reached their end of life. It is recommended to upgrade to a newer version of PHP for continued support and security updates.

## Installation

### 1. **Clone the Repository**

   First, clone this repository to your local machine using Git:

   ```sh
   git clone https://github.com/ivkeapp/ci4-admin-api.git
   ```
### 2. **Install Dependencies**

Navigate to the project directory and install the PHP dependencies using Composer:
```sh
cd your-project-directory
composer install
```
### 3. **Environment Configuration**

Copy the .env.example file to .env and customize it according to your environment:
```sh
cp .env.example .env
```
Make sure to set the baseURL and configure your database settings in the .env file.

### 4. **Database Setup**

```sh
php spark migrate
php spark db:seed YourSeeder
```

If your application uses a database, run the migrations and seeders to set up your database:

### 5. **Running the Application**

- #### Development Server:
```
php spark serve
```
You can start the built-in development server by running:

This will start the server on http://localhost:8080.

- #### Production Environment:

For a production environment, configure your web server to point to the project's public folder. Ensure that you have properly configured the .env file with your production settings.

### Running Tests
```sh
./vendor/bin/phpunit
```
To run the test suite, ensure you have PHPUnit installed and configured as per the instructions in tests/README.md. You can run the tests using the following command:

For more detailed instructions on running tests, including generating code coverage reports, refer to tests/README.md.

### Contributing
We welcome contributions! Feel free to report bugs, request features, and submit pull requests.

License
This project is licensed under the MIT License - see the [LICENSE](https://github.com/ivkeapp/ci4-admin-api?tab=MIT-1-ov-file) file for details.

Additional Resources
- [CodeIgniter 4 User Guide](https://codeigniter.com/user_guide/)
- [CodeIgniter 4 Forums](https://forum.codeigniter.com/)
- [Composer](https://getcomposer.org/)

This README provides a comprehensive guide for setting up and running the CodeIgniter 4 application on another machine, including server requirements, installation steps, database setup, running the application, and running tests.

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> The end of life date for PHP 7.4 was November 28, 2022.
> The end of life date for PHP 8.0 was November 26, 2023.
> If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> The end of life date for PHP 8.1 will be November 25, 2024.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
