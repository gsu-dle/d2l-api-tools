<?php

declare(strict_types=1);

namespace GGAState\Tools\D2L\Model\Grades;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Whenever you see a _{ \<composite:RichTextInput\> }_ field in a JSON example, that stands in for a composite block like 
 * this:
 * ```text
 * {
 *   "Content": <string>,
 *   "Type": "Text|Html"
 * }
 * ```
 * _Note_: For the _type_ field, you must provide either the value “Text” or “Html”, depending upon the formatting of 
 * the content string you are providing to the back-end service.
 * 
 * @package GAState\Tools\D2L\Model\Grades
 * @access public
 * @see https://docs.valence.desire2learn.com/res/grade.html#Grade.AssociatedTool
 */
class GradesAssociatedToolModel extends D2LModel
{
    /**
     * @var int $ToolId
     */
    public int $ToolId = 0;

    /**
     * @var int $ToolItemId
     */
    public int $Type = 0;
}
