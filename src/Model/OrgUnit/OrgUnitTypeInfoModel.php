<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Encapsulates the core information associated with an org unit type for use by other services (for example, the 
 * Enrollment and Course related actions).
 * 
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.OrgUnitTypeInfo
 */
class OrgUnitTypeInfoModel extends D2LModel
{
    /**
     * @var int $Id
     */
    public int $Id = 0;

    /**
     * @var string $Code
     */
    public string $Code = '';

    /**
     * @var string $Name
     */
    public string $Name = '';
}
