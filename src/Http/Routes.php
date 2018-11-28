<?php

$router->group(['middleware' => 'web'], function ($router) {
    // Appprove
    $router->get('/approve/{token}', 'PendingApprovalController@approve');
    // Deny
    $router->get('/deny/{token}', 'PendingApprovalController@deny');
});
