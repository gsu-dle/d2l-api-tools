<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * When you have permission to see the distinction between a user’s legal and preferred names, you can view and set 
 * these name values
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.LegalPreferredNames
 */
class LegalPreferredNamesModel extends D2LModel
{
    /**
     * Users must always have legal names; when setting names, you must always provide a value for the two Legal name 
     * fields.
     * 
     * These fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * 
     * @var string $LegalFirstName
     */
    public string $LegalFirstName = '';

    /**
     * Users must always have legal names; when setting names, you must always provide a value for the two Legal name 
     * fields.
     * 
     * These fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * 
     * @var string $LegalLastName
     */
    public string $LegalLastName = '';

    /**
     * Users need not have preferred names; when setting names, you may provide null for one or both of the Preferred 
     * name fields to note that the user has no preferred version of that name other than their legal name(s).
     * 
     * If not null, these fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * 
     * @var string|null $PreferredFirstName
     */
    public ?string $PreferredFirstName = null;

    /**
     * Users need not have preferred names; when setting names, you may provide null for one or both of the Preferred 
     * name fields to note that the user has no preferred version of that name other than their legal name(s).
     * 
     * If not null, these fields both must be valid name strings for users: they cannot be solely composed of whitespace.
     * @var string|null $PreferredLastName
     */
    public ?string $PreferredLastName = null;

    /**
     * This field provides a way to set the last name by which the back end service will sort users for presentation in 
     * various lists.
     * 
     * When a value is present, the back-end service uses the SortLastName in place of place of PreferredLastName or 
     * LegalLastName as the last name sorting key.
     * 
     * However, users need not have a SortLastName; when setting names, you may provide null for the SortLastName field 
     * to note that the user has no SortLastName different from their other last names. In this case the back end 
     * service will use one of the PreferredLastName or LegalLastName as the last name sorting key.
     * 
     * If not null, this field must be a valid name string for users: it cannot be solely composed of whitespace.
     * 
     * @var string|null $SortLastName
     */
    public ?string $SortLastName = null;
}
