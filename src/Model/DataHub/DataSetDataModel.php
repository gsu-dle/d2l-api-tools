<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about all of the built-in data sets available for you to use for your data export.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#DataExport.DataSetData
 */
class DataSetDataModel extends D2LModel
{
    /** 
     * The GUID for an available data set on the back-end service.
     * 
     * @var string $DataSetId
     */
    public string $DataSetId = '';

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $Description
     */
    public string $Description = '';

    /**
     * The category of the data set on the back-end service (e.g. Insights).
     * 
     * @var string $Category
     */
    public string $Category = '';

    /** 
     * @var array<DataSetFilterModel> $Filters
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
                $this->Filters[] = new DataSetFilterModel($filter);
            }
        }
        unset($values->Filters);

        parent::setValues(values: $values);
    }
}
