<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;
use GAState\Tools\D2L\Model\User\UserModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Enrollment.OrgUnitUser
 */
class OrgUnitUserModel extends D2LModel
{
    /**
     * @var UserModel $User
     */
    public UserModel $User;

    /**
     * @var RoleInfoModel $Role
     */
    public RoleInfoModel $Role;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'User') && is_object($values->User)) {
            $this->User = new UserModel(values: $values->User);
        }
        if (property_exists($values, 'Role') && is_object($values->Role)) {
            $this->Role = new RoleInfoModel(values: $values->Role);
        }
    }
}
