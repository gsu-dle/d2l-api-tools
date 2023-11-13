<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\{
    Exception\D2LExpectedObjectException,
    Model\Enrollment\EnrollmentDataModel,
    Model\Enrollment\CreateEnrollmentDataModel
};
use GAState\Tools\D2L\Model\API\ObjectListPageModel;
use GAState\Tools\D2L\Model\Enrollment\ClasslistUserModel;

class EnrollmentAPI extends D2LAPI
{
    /**
     * Delete a user’s enrollment in a provided org unit.
     * 
     * @param int $orgUnitId Org unit ID.
     * @param int $userId User ID.
     * 
     * @return EnrollmentDataModel Unlike most delete actions, this action returns an EnrollmentData JSON block showing 
     * the enrollment status just before this action deleted the user’s enrollment.
     * 
     * @see https://docs.valence.desire2learn.com/res/enroll.html#delete--d2l-api-lp-(version)-enrollments-orgUnits-(orgUnitId)-users-(userId)
     * @see https://docs.valence.desire2learn.com/res/enroll.html#delete--d2l-api-lp-(version)-enrollments-users-(userId)-orgUnits-(orgUnitId)
     */
    public function deleteEnrollment(
        int $orgUnitId,
        int $userId
    ): EnrollmentDataModel {
        $response = $this->callAPI(
            product: 'lp',
            action: 'DELETE',
            route: "/enrollments/orgUnits/{$orgUnitId}/users/{$userId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new EnrollmentDataModel(values: $response->data);
    }

    /**
     * @param int $orgUnitId
     * @param bool $onlyShowShownInGrades
     * @param string|null $searchTerm
     * 
     * @return array<ClasslistUserModel>
     * 
     * @see
     */
    public function getClassList(
        int $orgUnitId,
        bool $onlyShowShownInGrades = false,
        ?string $searchTerm = null
    ): array {
        /** @var EnrollmentAPI $that */
        $that = $this;

        /** @var callable(string|null $next): ObjectListPageModel $callAPI*/
        $callAPI = function (?string $next) use (
            $that,
            $orgUnitId,
            $onlyShowShownInGrades,
            $searchTerm
        ) {
            return $that->getPagedClassList(
                orgUnitId: $orgUnitId,
                onlyShowShownInGrades: $onlyShowShownInGrades,
                searchTerm: $searchTerm,
                next: $next
            );
        };

        /** @var array<ClasslistUserModel> */
        return $this->objectListAPI(
            callAPI: $callAPI,
            keyField: 'Identifier'
        );
    }

    /**
     * @param int $orgUnitId
     * @param bool $onlyShowShownInGrades
     * @param string|null $searchTerm
     * @param string|null $next
     * 
     * @return ObjectListPageModel
     * 
     * @see
     */
    public function getPagedClassList(
        int $orgUnitId,
        bool $onlyShowShownInGrades = false,
        ?string $searchTerm = null,
        ?string $next = null
    ): ObjectListPageModel {
        $params = [
            'onlyShowShownInGrades' => $onlyShowShownInGrades,
            'searchTerm' => $searchTerm,
            'bookmark' => $next
        ];
        $response = $this->callAPI(
            product: 'le',
            action: 'GET',
            route: "/{$orgUnitId}/classlist/paged/",
            params: $params
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new ObjectListPageModel(
            values: $response->data,
            createObject: function (object $values) {
                return new ClasslistUserModel(values: $values);
            }
        );
    }

    public function getEnrolledUsers(int $orgUnitId): void
    {
    }

     
    public function getUserEnrollments(int $userId): void
    {
    }

    /**
     * Get a user’s enrollment in a provided org unit.
     * 
     * @param int $userId    User ID
     * @param int $orgUnitId Org Unit ID
     * 
     * @return EnrollmentDataModel 
     * 
     * @see https://docs.valence.desire2learn.com/res/enroll.html#get--d2l-api-lp-(version)-enrollments-users-(userId)-orgUnits-(orgUnitId)
     */
    public function getEnrollment(
        int $userId,
        int $orgUnitId
    ): EnrollmentDataModel {

        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/enrollments/users/{$userId}/orgUnits/{$orgUnitId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new EnrollmentDataModel(values: $response->data);
    }
    
    /**
     * Create a user’s enrollment in a provided org unit.
     * 
     * @param CreateEnrollmentDataModel $newEnrollment Data for new enrollment.
     * 
     * @return EnrollmentDataModel 
     * 
     * @see https://docs.valence.desire2learn.com/res/enroll.html#post--d2l-api-lp-(version)-enrollments-
     */
    public function createEnrollment(CreateEnrollmentDataModel $newEnrollment): EnrollmentDataModel
    {
        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/enrollments/",
            data: $newEnrollment
        );
    
        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        return new EnrollmentDataModel(values: $response->data);
    }
}
