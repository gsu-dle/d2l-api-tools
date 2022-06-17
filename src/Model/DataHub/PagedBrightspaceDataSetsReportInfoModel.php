<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\DataHub;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains paged information about the plugins that are available for you to use with Brightspace Data
 * Sets.
 */
class PagedBrightspaceDataSetsReportInfoModel extends D2LModel
{
    /**
     * An absolute APIURL you can use to navigate to the next page of available plugins.
     * 
     * @var string|null $NextPageURL
     */
    public ?string $NextPageURL = null;

    /**
     * An absolute APIURL you can use to navigate to the previous page of available plugins.
     * 
     * @var string|null $PrevPageURL
     */
    public ?string $PrevPageURL = null;

    /** 
     * @var array<BrightspaceDataSetReportInfoModel> $BrightspaceDataSets
     */
    public array $BrightspaceDataSets = [];

    /**
     * Set model values
     * 
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "BrightspaceDataSets") && is_array($values->BrightspaceDataSets)) {
            foreach ($values->BrightspaceDataSets as $dataSet) {
                $this->BrightspaceDataSets[] = new BrightspaceDataSetReportInfoModel($dataSet);
            }
        }
        unset($values->BrightspaceDataSets);

        parent::setValues(values: $values);
    }
}
