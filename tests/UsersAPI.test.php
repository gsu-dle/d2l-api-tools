<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\UsersAPI;
use GAState\Tools\D2L\Exception\D2LResponseException;

global $d2l;

require 'Bootstrap.php';

main: {
    $usersAPI = new UsersAPI($d2l);

    try {
        // var_dump($usersAPI->whoAmI());

        // var_dump($usersAPI->getUser(userName: 'admin.mforest'));

        // var_dump($usersAPI->getUserActivation(1916347));

        // var_dump($usersAPI->getUserProfile(profileId: 'nU5FKua2a4'));

        var_dump($usersAPI->listUserRoles());

        var_dump($usersAPI->getUserRole(774));
    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
}
