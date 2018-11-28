<?php

$router->group(['middleware' => 'web'], function ($router) {
    // Appprove
    $router->get('/approve/{token}', 'Httpfactory\Approvals\Http\Controllers\PendingApprovalController@approve');
    // Deny
    $router->get('/deny/{token}', 'Httpfactory\Approvals\Http\Controllers\PendingApprovalController@deny');
});
