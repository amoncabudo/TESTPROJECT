<?php

function ctrluserslist($request, $response, $container){
    $userModel = $container->Users();

    $users = $userModel->getAllUsers();

    $response->set('users', $users);
    $response->setTemplate("index.php");

    return $response;
}