<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about a data export job.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#DataExport.ExportJobData
 */
class ExportJobDataModel extends D2LModel
{
    /**
     * The GUID for a given export of a particular data set.
     * 
     * @var string $ExportJobId 
     */
    public string $ExportJobId = '';

    /**
     * The GUID representing a specific data set type.
     * 
     * @var string $DataSetId 
     */
    public string $DataSetId = '';

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $SubmitDate
     */
    public string $SubmitDate = '';

    /**
     * @var ExportJobStatusType $Status
     */
    public ExportJobStatusType $Status = ExportJobStatusType::NotSet;

    /**
     * The category of the data set on the back-end service (e.g. Insights).
     * 
     * @var string $Category 
     */
    public string $Category = '';

    /**
     * Set model values
     * 
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'Status') && is_numeric($values->Status)) {
            $this->Status = ExportJobStatusType::from(intval($values->Status));
        }
        unset($values->Status);

        parent::setValues(values: $values);
    }
}
