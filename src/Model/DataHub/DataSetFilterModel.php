<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about a filter definition for a data set.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#DataExport.DataSetFilter
 */
class DataSetFilterModel extends D2LModel
{
    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var ExportFilterType $Type
     */
    public ExportFilterType $Type = ExportFilterType::NotSet;

    /**
     * @var string $Description
     */
    public ?string $Description = null;

    /** 
     * Filter default value converted to a string.
     * 
     * @var string $DefaultValue
     */
    public ?string $DefaultValue = null;

    /**
     * Set model values
     * 
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'Type') && is_numeric($values->Type)) {
            $this->Type = ExportFilterType::from(intval($values->Type));
        }
        unset($values->Type);

        parent::setValues(values: $values);
    }
}
