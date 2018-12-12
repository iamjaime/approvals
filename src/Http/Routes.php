<?php

$router->group(['middleware' => 'web'], function ($router) {

    // Appprove
    $router->get('/approve/{token}', 'PendingApprovalController@approve');
    // Deny
    $router->get('/deny/{token}', 'PendingApprovalController@deny');


    //Create Approval Group
    $router->resource('group', 'GroupApprovalController');

});








/*
    - A group has many users
    - each user in the group has a "level" which is actually a level of clearance. ( will be used in the future )
    - each Group has "settings" ( the settings are customized for each individual group and control the approval/denial rules )
*/