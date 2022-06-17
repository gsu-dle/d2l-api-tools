<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about the plugins that are available for you to use with Brightspace Data Sets.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#BrightspaceDataSets.BrightspaceDataSetReportInfo
 */
class BrightspaceDataSetReportInfoModel extends D2LModel
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
     * A flag indicating if the plugin is a full or differential data set.
     * 
     * @var bool $FullDataSet
     */
    public bool $FullDataSet = false;

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

    /**
     * @var string|null $Version
     */
    public ?string $Version = null;

    /**
     * @var array<BrightspaceDataSetReportInfoModel>|null $PreviousDataSets
     */
    public ?array $PreviousDataSets = null;

    /**
     * The time at which the data set was queued for processing by the scheduled task.
     * 
     * @var string|null $QueuedForProcessingDate
     */
    public ?string $QueuedForProcessingDate = null;

    /**
     * Indicates if download information and link for this data set are currently available or unavailable. If true, 
     * the information and download links are provided for all present extracts (if extracts are not present for a data
     * set, the nullable information fields can still be null); otherwise, if false, the information and download links
     * for the data set are temporarily unavailable.
     * 
     * @var bool $CurrentlyAvailable
     */
    public bool $CurrentlyAvailable = false;

    /**
     * Set model values
     * 
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "PreviousDataSets") && is_array($values->PreviousDataSets)) {
            $this->PreviousDataSets = [];
            foreach ($values->PreviousDataSets as $dataSet) {
                unset($dataSet->PreviousDataSets);
                $this->PreviousDataSets[] = new BrightspaceDataSetReportInfoModel($dataSet);
            }
        }
        if (property_exists($values, "CreatedDate") && is_string($values->CreatedDate)) {
            $createdDate = strtotime($values->CreatedDate);
            if (is_numeric($createdDate)) {
                $this->CreatedDate = date('Y-m-d H:i:s', $createdDate);
            }
        }
        if (property_exists($values, "QueuedForProcessingDate") && is_string($values->QueuedForProcessingDate)) {
            $queuedForProcessingDate = strtotime($values->QueuedForProcessingDate);
            if (is_numeric($queuedForProcessingDate)) {
                $this->QueuedForProcessingDate = date('Y-m-d H:i:s', $queuedForProcessingDate);
            }
        }
        unset($values->PreviousDataSets, $values->CreatedDate, $values->QueuedForProcessingDate);

        parent::setValues(values: $values);
    }
}
