<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This block describes the linking relationship between a D2L user and a Google Apps user.
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.GoogleAppsLinkingItem
 */
class GoogleAppsLinkingItemModel extends D2LModel
{
    /**
     * The user’s D2L UserName property.
     * 
     * @var string $UserName
     */
    public string $UserName = '';

    /**
     * The user’s name in the Google Apps records (for example, Dale.Witherspoon).
     * 
     * @var string $ExternalUserName
     */
    public string $ExternalUserName = '';

    /**
     * The Google Apps domain for the user (for example, gmail.com).
     * 
     * @var string $Domain
     */
    public string $Domain = '';

    /**
     * If true, notify the user that the linkage has taken place, when it succeeds.
     * 
     * @var bool $ShouldNotify
     */
    public bool $ShouldNotify = false;
}
