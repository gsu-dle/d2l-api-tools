<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about the the various schema identifiers and the Brightspace Data Sets plugin 
 * identifiers which adhere to each schema.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#BrightspaceDataSets.BrightspaceDataSetSchemaInfo
 */
class BrightspaceDataSetSchemaInfoModel extends D2LModel
{
    /**
     * @var string $SchemaId
     */
    public string $SchemaId = '';

    /**
     * @var array<string> $PluginId
     */
    public array $PluginId = [];
}
