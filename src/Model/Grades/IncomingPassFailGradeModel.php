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
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.IncomingGradeValue
 */

class IncomingPassFailGradeModel extends D2LModel
{
    public ?object $Comments = null;
    public ?object $PrivateComments = null;
    public ?int $GradeObjectType = 2;
    public ?bool $Pass = null;   

    public function setComments(
        string $commentsType = "Text", 
        string $commentsContent = '',
        string $privateType = "Text",
        string $privateContent = ''
        ): void
    {
        $newComment = new RichTextInputModel();
        $newComment->Type = $commentsType;
        $newComment->Content = $commentsContent;

        $newPrivateComment = new RichTextInputModel();
        $newPrivateComment->Type = $privateType;
        $newPrivateComment->Content = $privateContent;
        
        $this->Comments = $newComment;
        $this->PrivateComments = $newPrivateComment;
    }
}