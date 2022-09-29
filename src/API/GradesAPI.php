<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    Exception\D2LResponseException,
    Exception\D2LExpectedObjectException,
    Exception\D2LExpectedArrayException,
    Model\API\PagedResultSetModel,
    Model\API\RichTextInputModel,
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
    Model\Grades\IncomingNumericGradeModel,
    Model\Grades\IncomingFinalAdjustedGradeModel,
    Model\Grades\IncomingPassFailGradeModel,
    Model\Grades\IncomingSelectBoxGradeModel,
    Model\Grades\IncomingTextGradeModel,
    Model\Grades\GradeStatisticsInfoModel
    
};
use InvalidArgumentException;

/**
 * A grade object describes a single point of assessment for an org unit, containing the parameters within
 *  which participants will get assessed. The framework supports the creation of four different types of 
 * GradeObjects, each with slightly different properties.
 * 
 * @package GAState\Tools\D2L\API
 * @access public
 * @see https://docs.valence.desire2learn.com/res/grade.html
 */
class GradesAPI extends D2LAPI
{

    /**
     * Retrieve all the current grade book objects for a particular org unit.
     * 
     * @param int|null $orgUnitId Org ID
     * 
     * @return mixed
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#get--d2l-api-le-(version)-(orgUnitId)-grades-
     * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.GradeObject
     */
    public function getGradeBook(?int $orgUnitId = null)
    {
        if (
            $orgUnitId !== null 
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/grades/"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        return $response->data;
            
    }
    /**
     * Delete a specific grade book object for a particular org unit.
     * 
     * @param int $orgUnitId Org unit ID
     * @param int $gradeObjectID Grade object ID
     * 
     * @return void
     * 
     * @see 
     * DELETE /d2l/api/le/(version)/(orgUnitId)/grades/(gradeObjectId)
     * route: "/users/{$userId}"
     */
    public function deleteGradeBookItem(int $orgUnitId, int $gradeObjectID): void
    {
        $this->callAPI(
            product: 'le',
            action: 'DELETE',
            route: "/$orgUnitId/grades/{$gradeObjectID}"
        );
       
    }

    /**
     * Retrieve a specific grade object for a particular org unit.
     * 
     * @param int $orgUnitId Org unit ID
     * @param int $gradeObjectID Grade object ID
     * 
     * @return GradesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#get--d2l-api-le-(version)-(orgUnitId)-grades-(gradeObjectId)
     * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.GradeObject
     */
    public function getGradeBookItem(
        int $orgUnitId = 0,
        int $gradeObjectID = 0
    ): GradesModel {
        
        if (
            ($orgUnitId <= 0 ) ||  ($gradeObjectID <= 0)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/grades/$gradeObjectID"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }
        //Will Re-examine later
        /** @phpstan-ignore-next-line */
        return new GradesModel(values: $response->data);
    }

/**
     * Create a new gradebook object for a particular org unit.
     * 
     * @param int $orgUnitId Org unit ID
     * @param CreateNumericGradeModel|CreateSelectBoxGradeModel|CreatePassFailGradeModel|CreateTextGradeModel $newGradeItem
     * 
     * @return GradesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#post--d2l-api-le-(version)-(orgUnitId)-grades-
     * @see https://docs.valence.desire2learn.com/res/grade.html#term-GRADEOBJ_T
     */
    public function createGradeBookItem(
        int $orgUnitId = 0, 
        CreateNumericGradeModel|CreateSelectBoxGradeModel|CreatePassFailGradeModel|CreateTextGradeModel $newGradeItem = null
        ): GradesModel {
        
        if (
            $orgUnitId > 0
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'POST',
                route: "/$orgUnitId/grades/",
                data: $newGradeItem
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }
        
        //Will Re-examine later
        /** @phpstan-ignore-next-line */
        return new GradesModel(values: $response->data);
    }

     /**
     * Update a grade book object for a particular org unit.
     * 
     * @param int $orgUnitId
     * @param int $gradeObjectID
     * @param UpdateNumericGradeModel|UpdatePassFailGradeModel|UpdateSelectBoxGradeModel|UpdateTextGradeModel $gradeItem
     * 
     * @return GradesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#post--d2l-api-le-(version)-(orgUnitId)-grades-
     * @see https://docs.valence.desire2learn.com/res/grade.html#term-GRADEOBJ_T
     */
    public function updateGradeBookItem(
        int $orgUnitId = 0, 
        int $gradeObjectID = 0, 
        UpdateNumericGradeModel|UpdatePassFailGradeModel|UpdateSelectBoxGradeModel|UpdateTextGradeModel $gradeItem = null
        ): GradesModel {
        
        if (
            ( $orgUnitId > 0 ) && ( $gradeObjectID > 0 ) 
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'PUT',
                route: "/$orgUnitId/grades/$gradeObjectID",
                data: $gradeItem
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }
        
        //Will Re-examine later
        /** @phpstan-ignore-next-line */
        return new GradesModel(values: $response->data);
    }

    

   

    
/*****************
   /**
     * Retrieve the final grade value for a particular user.
     * 
     * @param int $orgUnitId
     * @param int $userId
     * 
     * 
     * @return GradesModel
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#post--d2l-api-le-(version)-(orgUnitId)-grades-
     * @see https://docs.valence.desire2learn.com/res/grade.html#term-GRADEOBJ_T
     */
    public function getUserFinalGrade(
        int $orgUnitId = 0, 
        int $userId = 0
        ): GradesModel {
        
        if (
            ($orgUnitId > 0) && ($userId > 0)
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/grades/final/values/$userId"
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }
        
        //Will Re-examine later
        /** @phpstan-ignore-next-line */
        return new GradesModel(values: $response->data);
    } 

    /**
     * Provide a specific grade value for a particular user.
     * 
     * @param int $orgUnitId
     * @param int $userId
     * @param int $gradeObjectId
     * @param IncomingNumericGradeModel|IncomingPassFailGradeModel|IncomingSelectBoxGradeModel|IncomingTextGradeModel $gradeItem
     * 
     * 
     * @return string
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#post--d2l-api-le-(version)-(orgUnitId)-grades-
     * @see https://docs.valence.desire2learn.com/res/grade.html#term-GRADEOBJ_T
     */
    public function putGradeItem(
        int $orgUnitId, 
        int $gradeObjectId, 
        int $userId, 
        IncomingNumericGradeModel|IncomingPassFailGradeModel|IncomingSelectBoxGradeModel|IncomingTextGradeModel $gradeItem
        ) : string {
        
        if (
            ( $orgUnitId > 0 ) && ( $gradeObjectId > 0 )
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'PUT',
                route: "/$orgUnitId/grades/$gradeObjectId/values/$userId",
                data: $gradeItem
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }

        if ($response->data == '') { $success = 'Successfully Submitted Grade'; } 
        else { $success = 'Something Failed'; }
        return $success;
    } 

    /**
     * Get statistics for a specified grade item.
     * 
     * @param int $orgUnitId
     * @param int $gradeObjectId
     * 
     * 
     * @return GradeStatisticsInfoModel
     * 
     * @see https://docs.valence.desire2learn.com/res/grade.html#post--d2l-api-le-(version)-(orgUnitId)-grades-
     * @see https://docs.valence.desire2learn.com/res/grade.html#term-GRADEOBJ_T
     */
    public function getGradeItemStatistics(
        int $orgUnitId = 0, 
        int $gradeObjectId = 0
        ) {
        
        if (
            ( $orgUnitId > 0 ) || ( $gradeObjectId > 0 )
        ) {
            $response = $this->callAPI(
                product: 'le',
                action: 'GET',
                route: "/$orgUnitId/grades/$gradeObjectId/statistics",
            );
        } else {
            throw new InvalidArgumentException('Invalid or missing arguments');
        }
        
        //Will Re-examine later
        /** @phpstan-ignore-next-line */
        return new GradeStatisticsInfoModel(values: $response->data);
    } 
    
}
