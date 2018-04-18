# Blog

This blog was build during my web develpment learning path with [OpenClassrooms](https://openclassrooms.com/).

The goals was to apprehend PHP, OOP, MVC architectural pattern, and to learn more about dependencies, and GitHub.

Use Twig v2.4 (Required php 7.0), Namespaces, Bootstrap v4, jQuery v3.3.1, and PDO.

## Getting Started

### Prerequisites

* Local server environment or live server
* PHP v7.0
* MySQL v5.0 or higher


### Installing

* Clone or download the repository, and put files into your environment

```
https://github.com/vlescot/Blog.git
```

* Create or import a **database** with the selected files **on the folder /SQL/** 'structure.sql', 'datas.sql' or 'database.sql'.
* Create a folder named **/Conf/ on the root folder** then create two files with following name and contents :

Create the file named **DBAccess.json** 
```json
{
    "Host":"Your DB Host", // e.g. localhost
    "Name":"Database_name", // e.g blog
    "Login":"Your_Login",
    "Password":"Your_Password"
}
 
```

Create the file named **MailAccess.json**
```json
{
    "Username":"Your_Email_Username",
    "Password":"Your_Password",
    "Host": "STMP_Host",
    "SMTPSecure": "SMTP_Secure_type", // e.g ssl
    "Port": "Port_Num"  // e.g 465
}

```
