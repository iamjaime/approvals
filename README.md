### Approval System  
The approval system package is an add-on package that allows seamless integration into laravel 5.7+

#### Installation  
To install simply pull in the package to your laravel project  
`composer install httpfactory\approvals`  
  
After you have successfully installed it via composer, you will need to  
register the package in your `config\app.php` file.  
  
Add the following line to your service providers array :  
`Httpfactory\Approvals\ApprovalServiceProvider::class`  
  
After registering the package, you will need to run migrations

#### Run The Migrations  
you must run your migrations as follows  
`php artisan migrate`

#### Usage  
There are multiple types of approvals :  
  
  1. Quick Approval ( 1 to 1 )
  2. Group Approval ( a group of users must approve/deny )
  3. MultiTier Approval ( multiple groups must approve/deny )
  
  
#### Quick Approval  
Below is an example of a quick approval :  

```
<?php

namespace Acme\SomeProject;

use Httpfactory\Approvals\QuickApproval;

class Someclass {
    
    public function requestApproval(){
        //Create a new Approval of certain type, then request the actual approval.
        $approval = new QuickApproval();
        $approval->title = 'Credit Card';
        $approval->description = 'Requesting Permission to use the company credit card for something cool';
        $approval->approvalsNeeded = 1;

        $approval->from(['User 1'])->sendRequest();
    }

}
```  
  
In the example above, we are sending a request to a user for approval.
  