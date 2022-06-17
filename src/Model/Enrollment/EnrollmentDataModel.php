<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Enrollment.EnrollmentData
 */
class EnrollmentDataModel extends D2LModel
{
    /**
     * @var int $OrgUnitId
     */
    public int $OrgUnitId = 0;

    /**
     * @var int $UserId
     */
    public int $UserId = 0;

    /**
     * @var int $RoleId
     */
    public int $RoleId = 0;

    /**
     * @var bool $IsCascading
     */
    public bool $IsCascading = false;
}
