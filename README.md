# AppGen RESTful Backend Framework: XAMPP Stack
## Status
* Version: 0.1 alpha
* Stage: Development
## Introduction
AppGen XAMPP framework is developed for the purpose of supporting quick RESTful backend application generation for PHP development community. Simply drop in your data schema and the Enitity Models will be generated with a fully functional REST backend within seconds. To get going follow the 5 easy steps:
1. Download the ready-to-deploy application
2. UNZIP in the XAMPP htdocs folder
3. Open and configure the settings file in /classes/AppGen/Settings/settings.ini
4. Import POSTMAN collection from /tests/POSTMAN/*
5. RUN POSTMAN tests to confirm successful deployment
## Dependencies
* XAMPP v.3.3.0
* Apache 2.4
* PHP 8.2.12
* MySql 10.4.32-MariaDB
* PHP with PDO is a must have
## Configuration
Settings file path: /classes/AppGen/Settings/settings.ini
### Section system
* base_uri = "localhost/xampp_rest_app"; This is the application root without a starting salsh (/), which is usually a domain name in production environments.
* base_path = "xampp_rest_app" ; Please do not add salsh (/) at the start. Keep empty when application root is mapped to domain.
* version = "0.1" ; Software version. 0 series indicates software is in active development mode. Please this version is validated when making rest calls.
* rest_enabled = TRUE ; TRUE: REST Service enabled, FALSE: REST Service disbaled
### Section auth
* source_type = "INI" ;INI: PHP configuration file, DB: MySql Database (MySql not support in this release)
* source_ini_path = "/data/users.ini" ;Please set path after base_path. Don't forget to start with a /
### Section database
vendor = "MySql" ;Only MySql supported in this release.
version = "8.2.12" ; Only 8.2.12 version supported in this release.
server = "localhost"
username = "root"
password = ""
database = "appgen_example"
connection_type = "PDO" ; Only PDO supported in this release (OO: Object oriented, PROC: Procedural, PDO: PHP Data Objects).
## Testing using POSTMAN
### Collection variables with starting defaults
* REST_END_POINT = http://localhost/xampp_rest_app/rest/0.1
* API_KEY = eWBcTjh8Xk2lC5OxSuAwdTRArVdVxRyT
#### End Point: /User/list
List of Entities which are not deleted 
#### JSON Response
![image](https://github.com/user-attachments/assets/fc551568-c017-484c-88a1-2c124dfca5e4)
### End Point: /User/add
Add an Entity
#### Form Body
![image](https://github.com/user-attachments/assets/f574c990-89aa-4483-bb20-12ad53d43db7)
#### JSON Response
![image](https://github.com/user-attachments/assets/9b602767-f728-4fc8-8648-332047194a68)
### End Point: /User/modify
Modify Entity informtion 
#### Form Body
![image](https://github.com/user-attachments/assets/959f2269-3222-4474-8b68-5ed5a751e3a0)
#### JSON Response
![image](https://github.com/user-attachments/assets/821e4432-f379-4864-9dcf-db7cdd6b5685)
### End Point: /User/activate
Activate an Entity if feature is enabled
#### Form Body
![image](https://github.com/user-attachments/assets/7ba75627-38aa-44e7-8aa0-988fe92b387b)
#### JSON Response
![image](https://github.com/user-attachments/assets/57e8e34d-2fb4-4ebb-b4fb-96a110558d14)
### End Point: /User/deactivate
Deactivate an Entity if feature is enabled
#### Form Body
![image](https://github.com/user-attachments/assets/7ba75627-38aa-44e7-8aa0-988fe92b387b)
#### JSON Response
![image](https://github.com/user-attachments/assets/6bd4f4d1-42fc-406a-ad21-8c88f6e20766)
### End Point: /User/delete
Soft delete an Entity. Very helpful to maintain record trash by Entity
#### Form Body
![image](https://github.com/user-attachments/assets/7ba75627-38aa-44e7-8aa0-988fe92b387b)
#### JSON Response
![image](https://github.com/user-attachments/assets/0574059a-e726-447b-8ed0-c850f4388923)
### End Point: /User/undelete
Revoke deleting of an Entity. Very helpful restore deleted record from trash
#### Form Body
![image](https://github.com/user-attachments/assets/7ba75627-38aa-44e7-8aa0-988fe92b387b)
#### JSON Response
![image](https://github.com/user-attachments/assets/9473a231-f684-4af3-9190-83862422190b)
### End Point: /User/purge
Permanently delete a record. Please be careful when implementing end point in the front end. Enable only for responsible roles and provide warnings of action cannot be undone.
#### Form Body
![image](https://github.com/user-attachments/assets/7ba75627-38aa-44e7-8aa0-988fe92b387b)
#### JSON Response
![image](https://github.com/user-attachments/assets/8ffc3574-512b-4208-977b-17f41668a9a3)
