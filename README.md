# Random-User-Data-Generator
This project is a web application that generates random user data, including first name, last name, state, age, job, and gender, and displays it in a dynamically updating table. The application utilizes PHP for the back end and MySQL for data persistence. Data is generated and added to the database every 3 minutes, ensuring fresh entries for users to view. This project demonstrates basic web development skills using HTML, CSS, JavaScript, PHP, and MySQL.

Features:

Random user data generation
Data persistence with MySQL
Automatic updates every 3 minutes
Responsive and user-friendly interface. 

## PROCEDURE 

# Setting Up Your MySQL Database

## Step 1: Log into cPanel
Access your cPanel account using your hosting provider's login interface.

## Step 2: Locate the MySQL Databases Tool
In the cPanel dashboard, find the **Databases** section and click on **MySQL Databases**.

## Step 3: Create a New Database
1. In the **Create New Database** section, enter a name for your database (e.g., `user_data_db`).
2. Click on **Create Database**.
3. Note the database name, as you'll need it for your PHP scripts.

## Step 4: Create a Database User
1. Scroll down to the **MySQL Users** section.
2. Under **Add New User**, fill in the **Username** and **Password** fields.
3. Click on **Create User**.
4. Make sure to note down the username and password, as you'll use these in your PHP code.

## Step 5: Add User to the Database
1. In the **Add User to Database** section, select the user you just created from the dropdown menu.
2. Select the database (e.g., `user_data_db`) you created earlier.
3. Click on **Add**.
4. On the next screen, you’ll see options for user privileges. You can select **All Privileges** to allow the user full access to the database.
5. Click on **Make Changes**.

## Step 6: Create the Users Table
1. Go back to the Databases section and click on **phpMyAdmin**.
2. In phpMyAdmin, select your database (e.g., `user_data_db`) from the left sidebar.
3. Click on the **SQL** tab at the top.

## Step 7: Run the SQL Queries
In the SQL query box, paste the following SQL commands to create the users table:

```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
