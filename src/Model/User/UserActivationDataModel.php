<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.UserActivationData
 */
class UserActivationDataModel extends D2LModel
{
    /**
     * @var bool $IsActive
     */
    public bool $IsActive = false;
}
