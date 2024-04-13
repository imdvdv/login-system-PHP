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
* Google Fonts

### Getting Started 

To use this project, follow these steps:
1. Clone the repository to your local machine.
2. Configure Database.

   2.1 Create a new database with name `login_system` and import the prepared dump file `src/config/login_system.sql`.

   2.2 Edit the database connection details in the `src/config/env.php` file.

    ```php
     // Database params
    const DB_HOST = "your DB Host", 
        DB_NAME = "your DB Name", // "login_system" if you decide to use the database dump attached to the project
        DB_USERNAME = "your DB UserName", 
        DB_PASSWORD = "your DB Password",
        DB_PORT = "3306";
    ```
3. Configure email sending using sendmail.
   
    3.1 Enter YOUR DOMAIN name or localhost into the message variable in the `src/actions/access-recovery.php` file.
    ```php
      // Generate and send an email with a link to the password change page using the built-in mail function
      $message = 'To reset a password and create new - <a href="http://{YOUR_DOMAIN}/pages/change-password.php?code='.$code.'">click here</a>. </br>Reset your password in a hour.';
    ```
    3.2 Download and unzip the sendmail.zip from a trusted source if it doesn't exist in your development environment.
   
    3.3 Edit the php.ini file. For Windows, go to the [mail function] section and modify it as follows:

    ```ini
      [mail function]
      SMTP = your smtp server
      smtp_port = your port
      sendmail_from = your email address
      sendmail_path = your path to the sendmail.exe file 
    ```
    3.4 Configure the SMTP, smtp server username, password, and port in the sendmail.ini file.
    ```ini
      [sendmail]
      smtp_server= your smtp server
      smtp_port= your port
      auth_username= your email address
      auth_password= your password
      force_sender= your email address
    ```
4. Run the project on a server.

### Images
![signup page](https://github.com/imdvdv/PHP-Login-system/blob/master/signup.png)
![signup page with errors](https://github.com/imdvdv/PHP-Login-system/blob/master/signup-failure.png)
![login page](https://github.com/imdvdv/PHP-Login-system/blob/master/login.png)
![recovery page](https://github.com/imdvdv/PHP-Login-system/blob/master/recovery.png)
![change password page](https://github.com/imdvdv/PHP-Login-system/blob/master/change-password.png)
![profile page image1](https://github.com/imdvdv/PHP-Login-system/blob/master/profile1.png)
![profile page image2](https://github.com/imdvdv/PHP-Login-system/blob/master/profile2.png)
![profile page image3](https://github.com/imdvdv/PHP-Login-system/blob/master/profile3.png)
