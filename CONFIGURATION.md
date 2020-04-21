# Configuration Schema
The project only require changes in configuration file to be deployed.

**Type of configuration file**

* [Envirnoment](forms/assets/config.php)
    * Use to setup development and production envirnoment using domain name.
    * Basic details( email and contact number) of the organization.
    * Import all other common config files

* [Mail](forms/assets/configuration/mail.php)
    * Details used to connect to the mail server.

* Database ([dev](forms/assets/configuration/local/db.php) | [prod](forms/assets/configuration/server/db.php))
    * Details used to connect to the databse server.
    * Can create to different configuration for development and production.

* Payment Portal([dev](forms/assets/configuration/local/instamojo.php) | [prod](forms/assets/configuration/server/instamojo.php))
    * Details used to communicate with Instamojo Payment Portal
    * Can create to different configuration for development and production.

* [Event Details](forms/form-template/assets/conn/common_config.php)
    * Includes all configs and libraries require to run the system.
    * Define a relative path wrt to index.php
    * Deines DB's table name in which registration data get stored
    * Define data related to Event
### Note
A developer can deploy multiple forms by making mutliple copy of [form-template](/forms/form-template) folder and changing [Event Details](forms/form-template/assets/common_config.php) file.
