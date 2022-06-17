<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

/**
 * Data set export jobs will have one of several distinct statuses, depending on where they are in the export process.
 * 
 * @package GAState\Tools\D2L\Model\DataHub
 * @access public
 * @see https://docs.valence.desire2learn.com/res/dataExport.html#term-EXPORTJOBSTATUS_T
 */
enum ExportJobStatusType: int
{
    case NotSet = -1;
    case Queued = 0;
    case Processing = 1;
    case Complete = 2;
    case Error = 3;
    case Deleted = 4;
}
