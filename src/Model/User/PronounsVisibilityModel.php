<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * When you use an action to create a user, you pass in a block of new-user data
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.CreateUserData
 */
class PronounsVisibilityModel extends D2LModel
{
    public bool $ShowPronouns = false;
}
