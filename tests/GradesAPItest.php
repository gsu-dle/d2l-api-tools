<?php

declare(strict_types=1);

use GAState\Tools\D2L\API\GradesAPI;
use GAState\Tools\D2L\Model\API\RichTextInputModel;
use GAState\Tools\D2L\{
    Exception\D2LResponseException,
    Exception\D2LExpectedObjectException,
    Exception\D2LExpectedArrayException,
    Model\API\PagedResultSetModel,
    Model\Grades\CreateNumericGradeModel,
    Model\Grades\CreatePassFailGradeModel,
    Model\Grades\CreateSelectBoxGradeModel,
    Model\Grades\CreateTextGradeModel,
    Model\Grades\GradesAssociatedToolModel,
    Model\Grades\UpdateNumericGradeModel,
    Model\Grades\UpdatePassFailGradeModel,
    Model\Grades\UpdateSelectBoxGradeModel,
    Model\Grades\UpdateTextGradeModel,
    Model\Grades\GradesModel,
    Model\Grades\IncomingNumericGradeModel
};

global $d2l;

require 'Bootstrap.php';

main: {
    $GradesAPI = new GradesAPI($d2l);
   

    try {
        
        //Get All Grade Books items for an OU
        //var_dump($GradesAPI->getGradeBook(2273803));

        $test = $GradesAPI->getGradeBook(2273803);
        echo $test[0]->Name;

        //var_dump($GradesAPI->getGradeItem(2273803, 9317773));
        //$test2 = $GradesAPI->getGradeItem(2273803, 9317773);
        //echo $test2->AssociatedTool->ToolId;

        //Create Description for the update grade item object
        //$newRichTextInputModel = new RichTextInputModel();
        //$newRichTextInputModel->Type = 'Text';
        //$newRichTextInputModel->Content = 'PassFail Test From API3change';
    
        //Create NumericGradeObject to change grade book item
        //$newNumericGradeObject = new UpdateNumericGradeModel();
        //$newNumericGradeObject->MaxPoints = 100; 
        //$newNumericGradeObject->CanExceedMaxPoints = False;   
        //$newNumericGradeObject->IsBonus = False;  
        //$newNumericGradeObject->ExcludeFromFinalGradeCalculation = False;
        //$newNumericGradeObject->Name = "PassFail Test From API3 change";
        //$newNumericGradeObject->ShortName = "PassFail Test From API3 change";
        //$newNumericGradeObject->IsHidden = False;
        //$newNumericGradeObject->Description = $newRichTextInputModel;
        //var_dump($newGradeItem = $GradesAPI->updateGradeBookItem(2273803,9317773,$newNumericGradeObject));

        //Put a Grade for a Student in the Grade Book Item
        //$NumericIncomingGradeModel = new IncomingNumericGradeModel();
        //$NumericIncomingGradeModel->PointsNumerator = 10; 
        //$NumericIncomingGradeModel->setComments();
        //var_dump($GradesAPI->putGradeItem(2273803, 9312961, 1396250, $NumericIncomingGradeModel));    

        //Get Grade Item Statistics in course 
        $test = $GradesAPI->getGradeItemStatistics(2273803,9312961);
        print_r($test);


    } catch (D2LResponseException $ex) {
        var_dump($ex->getMessage(), $ex->response->statusCode, $ex->response->data);
    }
    }