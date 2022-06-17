<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\OrgUnit;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @see https://docs.valence.desire2learn.com/res/orgunit.html#OrgUnitEditor.ColourScheme
 */
class OrgUnitColourSchemeModel extends D2LModel
{
    /**
     * @var string $Dark
     */
    public string $Dark = '';

    /**
     * @var string $Light
     */
    public string $Light = '';

    /**
     * @var string $Soft
     */
    public string $Soft = '';
}
