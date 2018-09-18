# Blog 
[Have a look](http://vincentlescot.fr/P5/)

This blog was build during my web develpment learning path with [OpenClassrooms](https://openclassrooms.com/paths/developpeur-se-d-application-php-symfony).

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

* Create a **database** named **blog** and import selected files **from the folder /SQL/** 'database.sql'.
* Create a folder named **/Conf/ on the root folder** then create two files with following names and contents :

Create the file named **Path.json** 
```json
{
    "base_url": "http://localhost/dir_name/",
    "base_dir": "dir_name/"
}
 
```

Create the file named **DBAccess.json** 
```json
{
    "Host":"Your DB Host",
    "Name":"Database_name",
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
    "SMTPSecure": "SMTP_Secure_type", 
    "Port": "Port_Num" 
}

```

Have fun ! 
