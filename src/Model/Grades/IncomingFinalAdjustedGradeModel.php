<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Grades;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Final Adjusted Grade Value for a user
 * 
 * @package GAState\Tools\D2L\Model\Grades
 * @access public
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.IncomingFinalAdjustedGradeValue
 */

class IncomingFinalAdjustedGradeModel extends D2LModel
{
    public ?object $Comments = null;
    public ?object $PrivateComments = null;
    public ?int $PointsNumerator = null;
    public ?int $PointsDenominator = null;
}