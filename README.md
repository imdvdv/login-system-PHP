# PHP Login System

### Project Overview

This project is a PHP based login system.
The project is written in vanilla PHP without the use of frameworks and libraries.
The main goal of the project is to learn how to implement such functionality and understand how they work.

### Features


* __Registration:__ Users can register by providing a username, password, and email address.
* __Login:__ Registered users can log in using their username and password.
* __Remember Me:__ Users can visit his profile after terminating the session and closing the browser without re-entering the password using cookies.
* __Password recovery:__ Users can reset their password if they forget it by providing their email address.
* __Profile editing:__ Users can edit their profile information, including their username, email address, and profile picture or delete own profile.
* __Logout:__ Users can log out of their session and delete cookies if they exist.
* __Validation:__ The project implements validation of input data without using JavaScript. After submitting the form, the data is saved in session variables and displayed in form fields without the need to fill them out again in case of errors, and error messages are displayed each under its own field.

### Components

__Languages__
* PHP-8.2.4
* MariaDB-10.4.28
* HTML5
* CSS3

__External Resources/Plugins__
* Font awesome-6.4.0

### Getting Started 

You can use any local server for development:
* [OpenServer](https://ospanel.io/)
* [XAMPP](https://www.apachefriends.org/)
* [MAMP](https://www.mamp.info/)
* [Laragon](https://laragon.org/)
or others.

If you prefer to deploy an environment, you can use [Docker](https://www.docker.com/).
If you are working on Windows, use [WSL](https://learn.microsoft.com/ru-ru/windows/wsl/install).

To use this project, follow these steps:
1. Clone the repository to your local machine.
2. Create a new database and import the database.sql file.
3. Update the database connection details in the config.php file.

```php
 // Connecting to the database
const DB_HOST = "{your DB Host}", // "localhost" for local server
    DB_NAME = "{your DB Name}", 
    DB_USERNAME = "{your DB UserName}", // "root" for phpMyAdmin
    DB_PASSWORD = "{your DB Password}", // "password" or "" for phpMyAdmin
    DB_PORT = "3306";
```
4. Configure email sending using sendmail.
   
    4.1 Paste YOUR HOST value or domain name your project into the address bar in the access-recovery.php file.(localhost for example)
    ```php
      // Generate and send an email with a link to the password change page using the built-in mail function
      $message = 'To reset a password and create new - <a href="http://{YOUR HOST}/pages/change-password.php?code='.$code.'">click here</a>. </br>Reset your password in a hour.';
    ```
    4.2 Download and unzip the sendmail.zip from a trusted source if it doesn't exist in your development environment.
   
    4.3 Edit the php.ini file. For Windows, go to the [mail function] section and modify it as follows:

    ```ini
      [mail function]
      SMTP= your smtp server
      smtp_port= your port
      sendmail_from = your email address
      sendmail_path = your path to the sendmail.exe file 
    ```
    4.4 Configure the SMTP, smtp server username, password, and port in the sendmail.ini file.
    ```ini
      [sendmail]
      smtp_server= your smtp server
      smtp_port= your port
      auth_username= your email address
      auth_password= your password
      force_sender= your email address
    ```

6. Run the project on a server.

### Images
![signup page](https://github.com/imdvdv/PHP-Login-system/blob/master/signup.png)
![signup page with errors](https://github.com/imdvdv/PHP-Login-system/blob/master/signup-failure.png)
![login page](https://github.com/imdvdv/PHP-Login-system/blob/master/login.png)
![recovery page](https://github.com/imdvdv/PHP-Login-system/blob/master/recovery.png)
![change password page](https://github.com/imdvdv/PHP-Login-system/blob/master/change-password.png)
![profile page image1](https://github.com/imdvdv/PHP-Login-system/blob/master/profile1.png)
![profile page image2](https://github.com/imdvdv/PHP-Login-system/blob/master/profile2.png)
![profile page image3](https://github.com/imdvdv/PHP-Login-system/blob/master/profile3.png)



