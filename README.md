# Event Registration Form

The official event registration form used by [IEEE Student Branch DIT University](https://ieeeditu.org.in/), 2019.
The form is in use since September 2018.

It is a free, open-source and easy to deploy event registration portal written in PHP and paired with a MySQL or MariaDB database  with integrated frontend and backend. Can be deployed directly by updating a few configuration files according to the environment.

## Features
* Event Registration
* Integrated Payment Portal
* Support for offline payment record
* Support discount based on membership
* Support dynamic fee calculation based on registration count
* No code update required


## Technology Stack
* ### Frontend
    * Bootstrap 4
* ### Backend
    * PHP 7
* ### Database
    * MariaDB


## Getting Started
These instructions will get you a copy of the website up and running on your local machine for development and testing purposes.


### Prerequisites
What things you need to install the software and how to install them:
* Apache Server
* MySQL Server
* [Instamojo Account](https://www.instamojo.com/)
* Mail Credentails
* A Browser
* A IDE (only for development purpose)

### Installing
A step by step series of examples that tell you how to get a development env running

Step 1: Clone the repo. Visit [GitHub Guides](https://help.github.com/articles/cloning-a-repository/) to know how to clone the repository

Step 2: Move the `forms` folder to `htdocs` or `www` or `public_html` folder of your Server 

Step 3: Use the localdb.sql.sql file to create a tables in MySQL server. (Azuming you have all ready create Database)

Step 4: Edit configurtaion files. [More Info!](CONFIGURATION.md)


## Authors

* [**Himanshu Kotnala**](https://www.linkedin.com/in/aker99/) - [aker99](https://github.com/aker99)

### Contribution
**Development on the project has been discontinued by the [community](https://github.com/ieeeditu).**


## License
This project is licensed under the MIT License - see the [License.md](License.md) file for details
