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
class CreateUserDataModel extends D2LModel
{
    /**
     * If your back-end service has the d2l.Settings.OrgHasOrgDefinedId configuration variable set on, then org-defined 
     * IDs for user records, if they are set (not null), should be unique across the organization.
     * 
     * @var string|null $OrgDefinedId
     */
    public ?string $OrgDefinedId = null;

    /**
     * When creating a new user, the back-end service uses the first and last name fields to populate the legal first 
     * and last name of the user. If the user also has preferred versions of these names, you must set those separately 
     * after creating the user with their legal names.
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
     * When creating a new user, the back-end service uses the first and last name fields to populate the legal first 
     * and last name of the user. If the user also has preferred versions of these names, you must set those separately 
     * after creating the user with their legal names.
     * 
     * These fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * 
     * @var string $LastName
     */
    public string $LastName = '';

    /**
     * Your block of new-user data must either have a null value (if the user has no external email address) or it must 
     * have a well-formed email address in this field (if present, the service depends upon this email address to send 
     * password reset and/or account creation email to the new user). If you’re creating a utility user account, then 
     * you should provide the email address of an administration contact for that utility account.
     * 
     * @var string|null $ExternalEmail
     */
    public ?string $ExternalEmail = null;

    /**
     * @var string $UserName
     */
    public string $UserName = '';

    /**
     * @var int $RoleId
     */
    public int $RoleId = 0;

    /**
     * @var bool $IsActive
     */
    public bool $IsActive = false;

    /**
     * @var bool $SendCreationEmail
     */
    public bool $SendCreationEmail = false;

    /**
     * Sets the system-defined pronouns for the user. If you provide null for this field, the created user will have an 
     * empty value for the system-defined pronouns.
     * 
     * @var string|null $Pronouns
     */
    public ?string $Pronouns = null;
}
