# Event Registration Form

The official event registration form used by [IEEE Student Branch DIT University](https://ieeeditu.org.in/), 2019.
The form is in used since September 2018.

## Features
* Event Registration
* Integrated Payment Portal
* Support for offline payment record
* Support discount based on membership
* Support dynamic fee calculation based on registration count

## Getting Started
These instructions will get you a copy of the website up and running on your local machine for development and testing purposes.

### Prerequisites

What things you need to install the software and how to install them:
* Apache Server
* MySQL Server
* Instamojo Account to process payment
* Mail Credentails
* A Browser
* A IDE (only for development purpose)

### Installing

A step by step series of examples that tell you how to get a development env running

Step 1: Clone the repo. Visit [GitHub Guides](https://help.github.com/articles/cloning-a-repository/) to know how to clone the repository

Step 2: Move a folder to htdocs or www folder of your Server 

Step 3: Use the db.sql file to create a database in MySQL server

Step 4: Edit following files to change environment configurtaion
   - Instamojo Payment Portal: forms/assets/conn/configurations/credS.php (set credL.php) for local development
   - Database: forms/assets/conn/configurations/srvdb.php (set lcldb.php) for local development
   - Mail: forms/assets/conn/configurations/mail.php
   - Event Related Configuration: forms/form-template/assets/conn/common_config.php
