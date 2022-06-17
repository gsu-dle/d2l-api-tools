<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;
use stdClass;

/**
 * When you use an action to update a user’s data
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.UpdateUserData
 */
class UpdateUserDataModel extends D2LModel
{
    /**
     * @var string $OrgDefinedId
     */
    public string $OrgDefinedId = '';

    /**
     * If the user has preferred names set, then the back-end service uses these property values to update the user’s 
     * preferred names; otherwise, these property values update the user’s legal names. To update both sets of names 
     * precisely, use the update route with the LegalPreferredNames structure.
     * 
     * These fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * 
     * @var string $FirstName
     */
    public string $FirstName = '';

    /**
     * @var string|null $MiddleName
     */
    public ?string $MiddleName = null;

    /**
     * If the user has preferred names set, then the back-end service uses these property values to update the user’s 
     * preferred names; otherwise, these property values update the user’s legal names. To update both sets of names 
     * precisely, use the update route with the LegalPreferredNames structure.
     * 
     * These fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * 
     * @var string $LastName
     */
    public string $LastName = '';

    /**
     * @var string|null $ExternalEmail
     */
    public ?string $ExternalEmail = null;

    /**
     * @var string $UserName
     */
    public string $UserName = '';

    /**
     * @var UserActivationDataModel $Activation
     */
    public UserActivationDataModel $Activation;

    /**
     * Sets the system-defined pronouns for the user. If you provide null for this field, the previously set value will 
     * not be touched. If you want to reset the system-defined pronouns to empty for a user, you should provide an empty
     * string (“”) value for this field.
     * 
     * @var string|null $Pronouns
     */
    public ?string $Pronouns = null;

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
