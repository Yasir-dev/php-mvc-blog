# Creating MVC (Model View Controller) Framework to build a blog

I created this project for a coding challenge recently. The challenge was to create a Blog with PHP. The prerequisite for this coding challenge was to use MVC (Model View Controller) architectural approach. The use of any modern MVC Framework like Laravel, Symfony or Zend Framework was not allowed.


I always wondered how a MVC Framework works, so this was a good practice to create one. Althoug i have some first hand experience with Laravel Framework, which i used to create a small fun project.

**This project is only for learning purposes. If you really want to create a project using MVC architectural patteren use the modern PHP Frameworks (Laravel, Symfony or Zend Framework) available.**


## Model View Controller

![alt Mvc pattern image](https://github.com/Yasir-dev/php-mvc-blog/blob/master/mvc-pattern-image.jpg)

### Controller

* Controller is the part in MVC what the user interacts with.
* A controller get the request from the user and decide what to with it and responses to the user.
* Controller is also the only component inside MVC which interacts with the Model.

### Model

* Model is the part in MVC where data of an application is stored.
* It responsibility includes store and retrieve the data.
* Model knows nothing about the user interface

### View

* View is the part what the User sees.
* This is the data presention layer for the user.
* View knows nothing about Model.

## Advantages of MVC

* The biggest advantage is the *Separation of concern* which means separating business logic from the presentation logic.
* Code reusability (very fast development process)
* Better code organizaton (easy to maintain, understand and test code)
* Developer and designers can work in parallel 
* Developer can focus on business and backend logic without concerning about presentation logic and designer can work on the presentation without concerning about business logic)

## Requirements

* php: >=7.0.0
* MySQL
* HTTP Server - Nginx or Apache (tested with Apache)

## Blog

This blog project contains following features:

* User registration
* User login (using Sessin)
* Adding/editting/deleting user posts
* Adding/deleting comments for posts
* All post by a user
* All comments by a user

### Database 

The database contains three tables (users, posts and comments) 

```
CREATE TABLE `users` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`),
 UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

CREATE TABLE `posts` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `body` text COLLATE utf8_unicode_ci NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci

	CREATE TABLE `comments` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `post_id` int(11) NOT NULL,
 `username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
 `body` text COLLATE utf8_unicode_ci NOT NULL,
 `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
```
