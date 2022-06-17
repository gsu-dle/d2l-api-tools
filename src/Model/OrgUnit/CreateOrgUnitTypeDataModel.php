<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Actions that create or update custom org unit types should provide data to the service in blocks
 * 
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.CreateOrgUnitTypeData
 */
class CreateOrgUnitTypeData extends D2LModel
{
    /**
     * @var string $Code
     */
    public string $Code = '';

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $Description
     */
    public string $Description = '';

    /**
     * @var int $SortOrder
     */
    public int $SortOrder = 0;
}
