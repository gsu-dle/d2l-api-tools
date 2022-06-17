<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about the current Data Sets versions in the Organization.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#DataExport.DataSetsVersionInfo
 */
class DataSetsVersionInfoModel extends D2LModel
{
    /**
     * The current version for Brightspace Data Sets in the Organization.
     * 
     * @var string $BdsVersion 
     */
    public string $BdsVersion = '';
}
