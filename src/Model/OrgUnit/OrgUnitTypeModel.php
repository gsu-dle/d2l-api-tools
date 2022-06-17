<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Actions that retrieve Org Unit Type information from the service receive blocks
 * 
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.OrgUnitType
 */
class OrgUnitTypeModel extends D2LModel
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

    /**
     * @var string $Description
     */
    public string $Description = '';

    /**
     * @var int $SortOrder
     */
    public int $SortOrder = 0;

    /**
     * @var OrgUnitPermissionsModel $Permissions
     */
    public OrgUnitPermissionsModel $Permissions;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'Permissions') && is_object($values->Permissions)) {
            $this->Permissions = new OrgUnitPermissionsModel(values: $values->Permissions);
        }
        unset($values->Permissions);

        parent::setValues(values: $values);
    }
}
