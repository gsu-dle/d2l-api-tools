<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This user information block is the one handled by the WhoAmI service actions (notice that it’s different to the 
 * User.UserData information block handled by the User Management service actions).
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.WhoAmIUser
 */
class WhoAmIUserModel extends D2LModel
{
    /**
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * @var string $FirstName
     */
    public string $FirstName = '';

    /**
     * @var string $LastName
     */
    public string $LastName = '';

    /**
     * This field carries the same value as the UniqueIdentifier field in the User.UserData structure.
     * 
     * @var string $UniqueName
     */
    public string $UniqueName = '';

    /**
     * @var string $ProfileIdentifier
     */
    public string $ProfileIdentifier = '';

    /**
     * This field carries the currently chosen pronoun values by the user.
     * 
     * @var string $Pronouns
     */
    public ?string $Pronouns = '';
}
