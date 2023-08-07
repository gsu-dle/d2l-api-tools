<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;
use stdClass;

/**
 * When you use an action with the User Management service to retrieve a user’s data. Notice that it’s different to the 
 * User.WhoAmIUser information block provided by the WhoAmI service actions.
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.CreateUserData
 */
class UserDataModel extends D2LModel
{
    /**
     * @var int $OrgId
     */
    public int $OrgId = 0;

    /**
     * @var int $UserId
     */
    public int $UserId = 0;

    /**
     * @var string $FirstName
     */
    public string $FirstName = '';

    /**
     * @var string|null $MiddleName
     */
    public ?string $MiddleName = null;

    /**
     * @var string $LastName
     */
    public string $LastName = '';

    /**
     * @var string $UserName
     */
    public string $UserName = '';

    /**
     * @var string|null $ExternalEmail
     */
    public ?string $ExternalEmail = null;

    /**
     * @var string|null $OrgDefinedId
     */
    public ?string $OrgDefinedId = null;

    /**
     * @var string $UniqueIdentifier
     */
    public string $UniqueIdentifier = '';

    /**
     * @var UserActivationDataModel $Activation
     */
    public UserActivationDataModel $Activation;

    /**
     * @var string|null $DisplayName
     */
    public ?string $DisplayName = null;

    /**
     * @var string|null $LastAccessedDate
     */
    public ?string $LastAccessedDate = null;

    /**
     * This field will contain the system-definend pronouns for the user unless the user has chosen to set and display 
     * their own pronoun choices; in this latter case, this field will contain the user-defined pronoun choices.
     * 
     * @var string|null $Pronouns
     */
    public ?string $Pronouns = '';

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        $activation = property_exists($values, "Activation") && is_object($values->Activation) ? $values->Activation : new stdClass();
        $this->Activation = new UserActivationDataModel(values: $activation);
        unset($values->Activation);

        parent::setValues(values: $values);
    }
}
