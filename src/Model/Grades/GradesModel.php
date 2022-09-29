<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Grades;

use GAState\Tools\D2L\Model\D2LModel;
use GAState\Tools\D2L\Model\API\RichTextInputModel;

/**
 * Structure for the Grade information that the service exposes through the grade API.
 * 
 * @package GAState\Tools\D2L\Model\Grades
 * @access public
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.GradeObject
 */

class GradesModel extends D2LModel
{
    /**
     * @var int $MaxPoints
     */
    public ?int $MaxPoints = null;
    /**
     * @var bool $CanExceedMaxPoints
     */
    public ?bool $CanExceedMaxPoints = null;
    /**
     * @var bool $IsBonus
     */
    public ?bool $IsBonus = null;
    /**
     * @var bool $ExcludeFromFinalGradeCalculation
     */
    public ?bool $ExcludeFromFinalGradeCalculation = null;
    /**
     * @var string $GradeSchemeId
     */
    public ?string $GradeSchemeId = null;
    /**
     * @var string $Id
     */
    public ?string $Id = null;
    /**
     * @var string $Name
     */
    public ?string $Name = null;
    /**
     * @var string $ShortName
     */
    public ?string $ShortName = null;
    /**
     * @var string $GradeType
     */
    public ?string $GradeType = null;
    /**
     * @var string $CategoryId
     */
    public ?string $CategoryId = null;
     /**
     * @var object $Description
     */
    public ?object $Description = null;
     /**
     * @var string $GradeSchemeUrl
     */
    public ?string $GradeSchemeUrl = null;
     /**
     * @var object $AssociatedTool
     */
    public ?object $AssociatedTool = null;
    /**
     * @var string $IsHidden
     */
    public ?string $IsHidden = null;
    /**
     * @var string $Weight
     */
    public ?string $Weight = null;
}
