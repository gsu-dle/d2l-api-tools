<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\API;

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
 * @package GAState\Tools\D2L\Model\API
 * @access public
 * @see https://docs.valence.desire2learn.com/basic/conventions.html#term-RichTextInput
 */
class RichTextInputModel extends D2LModel
{
    /**
     * @var string $Content
     */
    public string $Content = '';

    /**
     * @var string $Content
     */
    public string $Type = '';
}
