<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Grades;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Structure for the Grade information that the service exposes through the grade API.
 * 
 * @package GAState\Tools\D2L\Model\Grades
 * @access public
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.IncomingGradeValue
 */

class CreateTextGradeModel extends D2LModel
{
    public ?string $Name = null;
    public ?string $ShortName = null;
    public ?string $GradeType = 'Text';
    public ?string $CategoryId = null;
    public ?object $Description = null;
    public ?int $Weight = null;
    public ?object $AssociatedTool = null;
    public ?bool $IsHidden = null;
}

