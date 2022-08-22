<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\IPSIS;

use GAState\Tools\D2L\Model\D2LModel;

class IPSISLogInfoRequestModel extends D2LModel
{
    /**
     * @var string|null $Bookmark
     */
    public ?string $bookmark = null;

    /**
     * @var string|null $Search
     */
    public ?string $Search = null;

    /**
     * @var array<string> $BatchIds
     */
    public array $BatchIds = [];

    /**
     * @var string|null $SortOrder
     */
    public ?string $SortOrder = 'Descending';

    /**
     * @var array<string> $LogLevels
     */
    public array $LogLevels = [];

    /**
     * @var array<string> $EntityTypes
     */
    public array $EntityTypes = [];

    /**
     * @var bool $Grouped
     */
    public bool $Grouped = false;

    /**
     * @var int $PageSize
     */
    public int $PageSize = 100;

    /**
     * @var string|null $Start
     */
    public ?string $Start = null;

    /**
     * @var string|null $End
     */
    public ?string $End = null;

    /**
     * @var int|null $End
     */
    public ?string $HashValue = null;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "BatchIds") && is_array($values->BatchIds)) {
            foreach ($values->BatchIds as $batchId) {
                $this->BatchIds[] = strval($batchId);
            }
        }
        unset($values->BatchIds);

        if (property_exists($values, "LogLevels") && is_array($values->LogLevels)) {
            foreach ($values->LogLevels as $logLevel) {
                $this->LogLevels[] = strval($logLevel);
            }
        }
        unset($values->LogLevels);

        if (property_exists($values, "EntityTypes") && is_array($values->EntityTypes)) {
            foreach ($values->EntityTypes as $entityType) {
                $this->EntityTypes[] = strval($entityType);
            }
        }
        unset($values->EntityTypes);

        parent::setValues(values: $values);
    }
}
