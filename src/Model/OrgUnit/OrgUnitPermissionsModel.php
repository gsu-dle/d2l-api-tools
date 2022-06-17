<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.Permissions
 */
class OrgUnitPermissionsModel extends D2LModel
{
    /**
     * @var bool
     */
    public bool $CanDelete = false;

    /**
     * @var bool
     */
    public bool $CanEdit = false;
}
