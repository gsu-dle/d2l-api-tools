<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\UsersAPI;
use GAState\Tools\D2L\Exception\D2LResponseException;
use GAState\Tools\D2L\Model\User\CreateUserDataModel;

global $d2l;

require 'bootstrap.php';

main: {
    $usersAPI = new UsersAPI($d2l);

    try {
        // var_dump($usersAPI->whoAmI());

        // var_dump($usersAPI->getUser(userName: 'admin.mforest'));

        // var_dump($usersAPI->getUserActivation(1916347));

        // var_dump($usersAPI->getUserProfile(profileId: 'nU5FKua2a4'));

        //var_dump($usersAPI->listUserRoles());

        //var_dump($usersAPI->getUserRole(774));

        $user1 = new CreateUserDataModel();
        $user1->FirstName = 'BatchTestUserFirstName';
        $user1->LastName = 'BatchTestUserLastName';
        $user1->UserName = 'BatchTestUserName';
        $user1->RoleId = 775;
        $user1->IsActive = true;

        $user2 = new CreateUserDataModel();
        $user2->FirstName = 'BatchTestUserFirstName2';
        $user2->LastName = 'BatchTestUserLastName2';
        $user2->UserName = 'BatchTestUserName2';
        $user2->RoleId = 775;
        $user2->IsActive = true;
        
        $usersArray[] = $user1;
        $usersArray[] = $user2;

        $test = $usersAPI->createUserBatch($usersArray);

        var_dump($test);



    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
}
