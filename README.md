### Approval System  
The approval system package is an add-on package that allows seamless integration into laravel 5.7+

#### Installation  
To install simply pull in the package to your laravel project  
`composer install httpfactory\approvals`  
  
After you have successfully installed it via composer, you will need to  
register the package in your `config\app.php` file.  
  
Add the following line to your service providers array :  
`Httpfactory\Approvals\ApprovalServiceProvider::class`  
  
Now you need to run the following command :  
`php artisan vendor:publish --provider=Httpfactory\Approvals\ApprovalServiceProvider`  
  
    
    
    
After registering the package, you will need to run migrations

#### Run The Migrations  
you must run your migrations as follows  
`php artisan migrate`

#### Events  
You will need to add the following events to the  `app\Providers\EventServiceProvider.php`  
  
##### Approval Approved Event ( fires off when an approval is approved )  
`Httpfactory\Approvals\Events\ApprovalApproved`  

##### Approval Denied Event ( fires off when an approval is denied )  
`Httpfactory\Approvals\Events\ApprovalDenied`  

##### Approval Request Event ( fires off when an approval request is sent )  
`Httpfactory\Approvals\Events\ApprovalRequest`  
  
The Events should look something like the code below    
```
           //Begin the approval events
           'Httpfactory\Approvals\Events\ApprovalRequest' => [
               'Httpfactory\Approvals\Listeners\ApprovalRequest',
           ],
   
           'Httpfactory\Approvals\Events\ApprovalApproved' => [
               'Httpfactory\Approvals\Listeners\ApprovalApproved',
           ],
   
           'Httpfactory\Approvals\Events\ApprovalDenied' => [
               'Httpfactory\Approvals\Listeners\ApprovalDenied',
           ],
```  
  
  
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
use App\User;

class Someclass {
    
    public function requestApproval(){
        
        //Some user instance that is requesting the approval...
        $user = User::find(1);
        $team_id = 1; //the team/company that the user belongs to
    
        //Create a new Approval of certain type, then request the actual approval.
        $approval = new QuickApproval($user, $team_id);
        $approval->name = 'Credit Card';
        $approval->description = 'Requesting Permission to use the company credit card for something cool';
        $approval->approvalsNeeded = 1;

        $usersThatIneedApprovalFrom = User::where('id', '!=', 1)->get();

        $approval->from($usersThatIneedApprovalFrom)->sendRequest();
    }

}
```  
  
In the example above, we are sending a request to a user for approval.
  
  