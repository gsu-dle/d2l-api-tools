<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\CoursesAPI;
use GAState\Tools\D2L\Model\Courses\CourseOfferingDataModel;
use GAState\Tools\D2L\Model\Courses\CreateCourseDataModel;
use GAState\Tools\D2L\Exception\D2LResponseException;
use GAState\Tools\D2L\Model\User\CreateUserDataModel;

global $d2l;

require 'Bootstrap.php';

main: {
    $CoursesAPI = new CoursesAPI($d2l);
    print gmdate("Y-m-d\TH:i:s\Z");

    try {
       //var_dump($CoursesAPI->getCourse(2884620));
        $newCourse = new CreateCourseDataModel();
        $newCourse->setVariables(
            "TestJeb",
            "TestJeb",
            1189040
        );
        var_dump($CoursesAPI->createCourse($newCourse));

    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }



}
