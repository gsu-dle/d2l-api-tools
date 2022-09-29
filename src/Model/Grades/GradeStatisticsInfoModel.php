<?php

/**
 * Get statistics for a specified grade item.  This is the return information
 * 
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.GradeStatisticsInfo
 * @see https://docs.valence.desire2learn.com/res/grade.html#get--d2l-api-le-(version)-(orgUnitId)-grades-(gradeObjectId)-statistics
 */

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Grades;

use GAState\Tools\D2L\Model\D2LModel;

class GradeStatisticsInfoModel extends D2LModel
{
    /**
     * @param string $OrgUnitId
    */
    public ?string $OrgUnitId = null;
    /**
     * @param int $GradeObjectId
    */
    public ?int $GradeObjectId = null;
    /**
     * @param float $Minimum
    */
    public ?float $Minimum = null;
    /**
     * @param float $Maximum
    */
    public ?float $Maximum = null;
    /**
     * @param array<int> $Average
    */
    public ?float $Average = null;
    /**
     * @phpstan-ignore-next-line
    */
    public ?array $Mode = null;
    /**
     * @param array<int> $Median
    */
    public ?float $Median = null;
    /**
     * @param array<int> $StandardDeviation
    */
    public ?float $StandardDeviation = null;
    
}