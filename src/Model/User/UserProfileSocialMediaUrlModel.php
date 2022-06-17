<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.UserProfile
 */
class UserProfileSocialMediaUrlModel extends D2LModel
{
    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $Url
     */
    public string $Url = '';
}
