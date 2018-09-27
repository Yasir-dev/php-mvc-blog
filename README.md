# Creating MVC (Model View Controller) Framework to build a blog

I created this project for a coding challenge recently. The challenge was to create a Blog with PHP. The prerequisite for this coding challenge was to use MVC (Model View Controller) architectural approach. The use of any modern MVC Framework like Laravel, Symfony or Zend Framework was the not allowed.


I always wondered how a MVC Framework works, so this was a good practice to create one. Althoug i have some first hand experience with Laravel Framework, which i used to create a small fun project.

**This project is only for learning purposes. If you really want to create a project using MVC architectural patteren use the modern PHP Frameworks (Laravel, Symfony or Zend Framework) available.**


## Model View Controller

![alt Mvc pattern image](https://github.com/Yasir-dev/php-mvc-blog/blob/master/mvc-pattern.jpg)

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

## What is the benefit of MVC?

* The biggest advantage is the *Separation of concern* which means separating business logic from the presentation logic.
* Code reusability (very fast development process)
* Better code organizaton (easy to maintain, understand and test code)
* Developer and designers can work in parallel 
* Developer can focus on business and backend logic without concerning about presentation logic and designer can work on the presentation without concerning about business logic)


