<?php

declare(strict_types=1);

use GAState\Tools\D2L\{
    Exception\D2LException,
    Exception\D2LResponseException,
    API\EnrollmentAPI,
    Model\Enrollment\EnrollmentDataModel,
    Model\Enrollment\CreateEnrollmentDataModel
};

global $d2l;

require 'Bootstrap.php';

main: {
    $EnrollmentAPI = new EnrollmentAPI($d2l);
    $EnrollmentDataModel = new CreateEnrollmentDataModel();
    
    try {
       
        //var_dump($EnrollmentAPI->getClassList(2273803));

        $EnrollmentDataModel->OrgUnitId = 2273803;
        $EnrollmentDataModel->UserId = 2015734;
        $EnrollmentDataModel->RoleId = 783;

        var_dump($EnrollmentAPI->createEnrollment($EnrollmentDataModel));

    
        var_dump($EnrollmentAPI->getEnrollment(2015734, 2273803));


    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
}
