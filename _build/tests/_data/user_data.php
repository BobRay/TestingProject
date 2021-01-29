<?php

$users = array(

    array(
        'username' => 'PrivateUser',
        'email' => 'someUser@gmail.com',
        'password' => 'somepassword',
        'active' => '1',
        'usergroup' => 'PrivateUsers',
        'role' => 'TestUser',
    ),

    array(
        'username' => 'PublicUser',
        'email' => 'someUser@gmail.com',
        'password' => 'somepassword',
        'active' => '1',
        'usergroup' => 'PublicUsers',
        'role' => 'TestUser',
    ),

    array(
        'username' => 'JoeTester2',
        'email' => 'someUser@gmail.com',
        'password' => 'TesterPassword',
        'active' => '1',
        'usergroup' => 'Administrator',
        'role' => 'Super User',
    ),
);

return $users;
