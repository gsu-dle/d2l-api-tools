<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Fundamental information for the organization itself (the root org unit).
 * 
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#Org.Organization
 */
class OrganizationModel extends D2LModel
{
    /**
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * Configured local time zone for the back-end Brightspace service.
     * 
     * @var string $TimeZone
     */
    public string $TimeZone = '';
}
