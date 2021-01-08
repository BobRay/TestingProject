<?php

$users = array(

    array(
        'username' => 'PrivateUser',
        'email' => 'someUser@gmail.com',
        'password' => 'somepassword',
        'active' => '1',
        'usergroup' => 'Private',
        'role' => 'TestRole',
    ),

    array(
        'username' => 'PublicUser',
        'email' => 'someUser@gmail.com',
        'password' => 'somepassword',
        'active' => '1',
        'usergroup' => 'Public',
        'role' => 'TestRole',
    ),

    array(
        'username' => 'JoeTester',
        'email' => 'someUser@gmail.com',
        'password' => 'TesterPassword',
        'active' => '1',
        'usergroup' => 'Administrator',
        'role' => 'Super User',
    ),
);

return $users;
