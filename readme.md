# CI - Shop

## CodeIgniter3 sales ERP with fairly limited features
This is a shallow copy of a project I developed in 2021, the goal of making this project opensource is to showcase what I can do (I do not have a lot of internet presence as I've always been on contract) and give upcoming and even experienced devs a new angle to look at CI from

### Disclaimer
Use this app however you see fit, just do not make me an accomplice if you do something negative with it. You might face a few breaks here and there though as CI3 is a PHP 7 framework.

## Setup
For a quick local setup:
- Download/Clone this repo.
- Install [XAMPP](https://sourceforge.net/projects/xampp/files/) with PHP 7 (This comes with all the goodies: PHP, MySQL, PHPMyAdmin etc.)
- Extract the contents of the downloaded file (if you downloaded the repo zip) to Xampp projects folder (typically `xampp/htdocs`)
- Run Xampp and start the first 2 services (typically: Apache and MySQL)
- Open the browser and go to [PHPMyAdmin](http://localhost/phpmyadmin)
- Create a database and name it `halmat`
- Open up the new database and click on import
- Import the file (at the root of your downloaded zip) `halmat.sql`
- You have successfully setup the project (The imported file comes with a few test users as shown below)

- Stakeholders:
    - Admin
    - Manager
    - Sales Personnel

- Modules:
    - Debtors
    - Expenses
    - Services
    - Reports

- Test Details:
    - Admin user: admin
    - Password: admin0
