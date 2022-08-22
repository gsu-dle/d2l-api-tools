<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\IPSIS;

use GAState\Tools\D2L\Model\D2LModel;

class PagedIPSISLogInfoModel extends D2LModel
{
    /**
     * @var string|null $Bookmark
     */
    public ?string $Bookmark = null;

    /**
     * @var int $Total
     */
    public int $Total = 0;

    /**
     * @var bool $HasMore
     */
    public bool $HasMore = false;

    /** 
     * @var array<IPSISLogEntryModel> $Items
     */
    public array $Items = [];

    /**
     * Set model values
     * 
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "Items") && is_array($values->Items)) {
            foreach ($values->Items as $logEntry) {
                $this->Items[] = new IPSISLogEntryModel($logEntry);
            }
        }
        unset($values->Items);

        parent::setValues(values: $values);
    }
}
