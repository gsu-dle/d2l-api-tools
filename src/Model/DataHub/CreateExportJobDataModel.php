<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about the built-in data set you want to use for your data export.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#DataExport.CreateExportJobData
 */
class CreateExportJobDataModel extends D2LModel
{
    /**
     * The GUID for an available data set on the back-end service.
     * 
     * @var string $DataSetId
     */
    public string $DataSetId = '';

    /** 
     * @var array<ExportJobFilterModel> $Filters 
     */
    public array $Filters = [];

    /**
     * Set model values
     * 
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "Filters") && is_array($values->Filters)) {
            foreach ($values->Filters as $filter) {
                $this->Filters[] = new ExportJobFilterModel($filter);
            }
        }
        unset($values->Filters);

        parent::setValues(values: $values);
    }
}
