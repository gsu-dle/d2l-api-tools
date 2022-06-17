<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Note that only the Name, Code, and Path values are used by the back-end service on update actions.
 * 
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.OrgUnitProperties
 */
class OrgUnitPropertiesModel extends D2LModel
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
     * In rare cases, an org unit may have no code set for it; in that case, you may get null for the code on actions 
     * that retrieve this structure. This is most likely to happen for the root organization org unit only. You may 
     * never provide null when setting the code for an org unit.
     * 
     * @var string|null $Code
     */
    public ?string $Code = null;

    /**
     * @var string|null $Path
     */
    public ?string $Path = null;

    /**
     * @var OrgUnitTypeInfoModel $Type
     */
    public OrgUnitTypeInfoModel $Type;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'Type') && is_object($values->Type)) {
            $this->Type = new OrgUnitTypeInfoModel(values: $values->Type);
        }
        unset($values->Type);

        parent::setValues(values: $values);
    }
}
