<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about the plugins that are available for you to use with Brightspace Data Sets.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#BrightspaceDataSets.DataSetReportInfo
 */
class DataSetsReportInfoModel extends D2LModel
{
    /**
     * The GUID for the requested Brightspace Data Sets plugin. This is the ID of the server-side plugin that creates 
     * the data set and refreshes the data.
     * 
     * @var string $PluginId 
     */
    public string $PluginId = '';

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $Description
     */
    public string $Description = '';

    /**
     * @var string|null $CreatedDate
     */
    public ?string $CreatedDate = null;

    /**
     * An absolute APIURL you can use to directly download this data set.
     * 
     * @var string|null $DownloadLink 
     */
    public ?string $DownloadLink = null;

    /**
     * @var int|null $DownloadSize
     */
    public ?int $DownloadSize = null;
}
