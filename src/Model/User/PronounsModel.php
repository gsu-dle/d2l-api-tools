<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * When you use an action to retrieve or update a user’s pronoun data
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.Pronouns
 */
class PronounsModel extends D2LModel
{
    /**
     * @var string|null $UserDefinedPronouns
     */
    public ?string $UserDefinedPronouns = null;

    /**
     * The back-end service only sends this field to API clients, it does not accept this field on update actions.
     * 
     * @var string|null $SystemDefinedPronouns
     */
    public ?string $SystemDefinedPronouns = null;

    /**
     * If true, user agrees to have their pronoun choices visible in the back-end service UI for others to see.
     * 
     * @var bool $ShowPronouns
     */
    public bool $ShowPronouns = false;

    /**
     * If true, the back-end service permits users to define and display their own pronoun choices set in the 
     * UserDefinedPronouns field. If false, the back-end service will only display the choices set in the 
     * SystemDefinedPronouns field.
     * 
     * @var bool $UseUserDefinedPronouns
     */
    public bool $UseUserDefinedPronouns = false;
}
