<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

/**
 * Data set filter types
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#term-EXPORTFILTERTYPE_T
 */
enum ExportFilterType: int
{
    case NotSet = 0;
    case DateTime = 1;
    case OrgUnit = 2;
    case Role = 3;
    case User = 4;
    case Boolean = 5;
}
