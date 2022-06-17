<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Actions that create or update custom org units should provide data to the service in blocks.
 * 
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.OrgUnitCreateData
 */
class OrgUnitCreateDataModel extends D2LModel
{
    /**
     * D2LID for the org unit’s associated org unit type.
     * 
     * @var int $Type
     */
    public int $Type = 0;

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * Note that org unit code values have these limitations:
     * - They cannot be more than 50 characters in length.
     * - They may not contain these special characters: \ : * ? “ ” < > | ‘  # , % &
     * 
     * @var string $Code
     */
    public string $Code = '';

    /**
     * JSON array of Org unit IDs that identify this org unit’s immediate parent org units.
     * 
     * @var array<int> $Parents
     */
    public array $Parents = [];

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'Parents') && is_array($values->Parents)) {
            foreach ($values->Parents as $parent) {
                $this->Parents[] = intval($parent);
            }
        }
        unset($values->Parents);

        parent::setValues(values: $values);
    }
}
