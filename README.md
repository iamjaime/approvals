###Approval System  
The approval system package is an add-on package that allows seamless integration into laravel 5.7+

####Installation  
To install simply pull in the package to your laravel project  
`composer install httpfactory\approvals`  
  
After you have successfully installed it via composer, you will need to  
register the package in your `config\app.php` file.  
  
Add the following line to your service providers array :  
`Httpfactory\Approvals\ApprovalServiceProvider::class`  
  
After registering the package, you will need to run migrations

#####Run The Migrations  
you must run your migrations as follows  
`php artisan migrate`

####Usage  
There are multiple types of approvals