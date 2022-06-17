<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Enrollment.UserOrgUnit
 */
class UserOrgUnitModel extends D2LModel
{
    /**
     * @var OrgUnitInfoModel $OrgUnit
     */
    public OrgUnitInfoModel $OrgUnit;

    /**
     * @var RoleInfoModel $Role
     */
    public RoleInfoModel $Role;

    /**
     * @var bool $IsCascading
     */
    public bool $IsCascading = false;

    /**
     * @var int|null $EnrolledByUserId If the enrollment was directly made by a user, provides the user ID of the person
     * who created this enrollment. If the enrollment was made by other methods such as an auto enrollment of a 
     * cascading role, the field will be `null`.
     */
    public ?int $EnrolledByUserId = null;

    /**
     * @var string|null $EnrolledByUserDate If the enrollment was directly made by a user, provides the date when this 
     * enrollment was created. If the enrollment was made by other methods such as an auto enrollment of a cascading 
     * role, the field will be `null`.
     */
    public ?string $EnrolledByUserDate = null;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'OrgUnit') && is_object($values->OrgUnit)) {
            $this->OrgUnit = new OrgUnitInfoModel(values: $values->OrgUnit);
        }
        unset($values->OrgUnit);

        if (property_exists($values, 'Role') && is_object($values->Role)) {
            $this->Role = new RoleInfoModel(values: $values->Role);
        }
        unset($values->Role);

        parent::setValues(values: $values);
    }
}
