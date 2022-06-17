<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnit.OrgUnitCoreInfo
 */
class OrgUnitCoreInfoModel extends D2LModel
{
    /**
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * @var string $TypeIdentifier
     */
    public string $TypeIdentifier = '';

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * In rare cases, an org unit may have no code set for it; in that case, you may get null for the code on actions 
     * that retrieve this structure. This is most likely to happen for the root organization org unit only.
     * 
     * @var string|null $Code
     */
    public ?string $Code = null;

    /**
     * @var string $Path
     */
    public string $Path = '';

    /**
     * @var bool $IsActive
     */
    public bool $IsActive = false;

    /**
     * These fields will have date-time values only for those org units that can have start and end times (for example, 
     * course offerings); otherwise, these fields will be null.
     * 
     * @var string|null $StartDate
     */
    public ?string $StartDate = null;

    /**
     * These fields will have date-time values only for those org units that can have start and end times (for example, 
     * course offerings); otherwise, these fields will be null.
     * 
     * @var string|null $EndDate
     */
    public ?string $EndDate = null;
}
