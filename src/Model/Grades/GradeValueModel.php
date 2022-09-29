<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Grades;

use GAState\Tools\D2L\Model\D2LModel;
use GAState\Tools\D2L\Model\API\RichTextInputModel;

/**
 * The framework can provide grade values slightly differently depending upon whether the underlying grade object type is a computable value, or not (basically, only Text (4) grade types are not computable).
 * 
 * @package GAState\Tools\D2L\Model\Grades
 * @access public
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.GradeValue
 */

class GradesModel extends D2LModel
{
    public ?string $UserId = null;
    public ?string $OrgUnitId = null;
    public ?string $DisplayedGrade = null;
    public ?string $GradeObjectIdentifier = null;
    public ?string $GradeObjectName = null;
    public ?int $GradeObjectType = null;
    public ?string $GradeObjectTypeName = null;
    public ?object $Comments = null;
    public ?object $PrivateComments = null;
    public ?string $LastModified = null;
    public ?string $LastModifiedBy = null;
    public ?string $ReleasedDate = null;

    public ?int $PointsNumerator = null;
    public ?int $PointsDenominator = null;
    public ?int $WeightedDenominator = null;
    public ?int $WeightedNumerator = null;


}
