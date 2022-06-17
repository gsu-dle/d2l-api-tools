<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.UserProfile
 */
class UserProfileBirthdayModel extends D2LModel
{
    /**
     * @var int $Month
     */
    public int $Month = 0;

    /**
     * @var int $Day
     */
    public int $Day = 0;
}
