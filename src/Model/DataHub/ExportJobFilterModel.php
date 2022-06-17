<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains information about a filter to apply to a data export.
 * 
 * Here are the filters you can use, along with sample value formats:
 * 
 * Filter name                  Example values
 * ------------------------------------------------------------------------------
 * startDate, endDate ^         2016-02-24
 *                              2016-01-28T19:39:19.7687Z
 * ------------------------------------------------------------------------------
 * parentOrgUnitId              6808
 * ------------------------------------------------------------------------------
 * roles                        578
 *                              578,901
 * ------------------------------------------------------------------------------
 * userId                       10283
 *                              "" - Empty string
 * ------------------------------------------------------------------------------
 * 
 * ^ Filters support only UTC date-time values
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#DataExport.ExportJobFilter
 */
class ExportJobFilterModel extends D2LModel
{
    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $Name
     */
    public string $Value = '';
}
