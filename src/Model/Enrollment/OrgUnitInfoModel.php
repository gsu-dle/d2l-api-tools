<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;
use GAState\Tools\D2L\Model\OrgUnit\OrgUnitTypeInfoModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Enrollment.OrgUnitInfo
 */
class OrgUnitInfoModel extends D2LModel
{
    /**
     * @var int Id
     */
    public int $Id = 0;

    /**
     * @var OrgUnitTypeInfoModel $Type
     */
    public OrgUnitTypeInfoModel $Type;

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string|null $Code In rare cases, an org unit may have no code set for it; in that case, you may get null for
     * the code on actions that retrieve this structure. This is most likely to happen for the root organization org 
     * unit only.
     */
    public ?string $Code = null;

    /**
     * @var string|null $HomeUrl The value will be `null` when the user cannot access the org unit.
     */
    public ?string $HomeUrl = null;

    /**
     * @var string|null $ImageUrl A value will only be provided for course offerings that have an image set; in all 
     * other situations the value will be `null`.
     */
    public ?string $ImageUrl = null;


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
