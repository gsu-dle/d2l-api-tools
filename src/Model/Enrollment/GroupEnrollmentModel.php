<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Group.GroupEnrollment
 */
class GroupEnrollmentModel extends D2LModel
{
    /**
     * @var int $UserId
     */
    public int $UserId = 0;
}
