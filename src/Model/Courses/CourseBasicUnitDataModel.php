<?php
/**
 * D2L Api Package
 * Course Basic Unit Data Model
 *
 * PHP version 8.2
 *
 * @category PHP
 * @package  D2L-API-Tools
 * @author   Melody Kimball <mforest@gsu.edu>
 * @author   Jeb Barger <jbarger@gsu.edu>
 * @license  https://github.com/gsu-dle/d2l-api-tools/blob/main/LICENSE BSD Licence
 * @link     https://github.com/gsu-dle/d2l-api-tools
 */
declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Courses;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This composite contains basic information about an organizational 
 * unit to which a course offering is related.
 * 
 * @category PHP
 * @package  GAState\Tools\D2L\Model\CourseOfferingDataModel
 * @author   Melody Kimball <mforest@gsu.edu>
 * @author   Jeb Barger <jbarger@gsu.edu>
 * @access   public
 * @license  https://github.com/gsu-dle/d2l-api-tools/blob/main/LICENSE BSD Licence
 * @link     https://github.com/gsu-dle/d2l-api-tools
 * @see      https://docs.valence.desire2learn.com/res/course.html#Course.BasicOrgUnit
 */
class CourseBasicUnitDataModel extends D2LModel
{
    /**
     * Identifier
     *
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * Name
     *
     * @var string $Name
     */
    public string $Name = '';

    /**
     * Identifier
     *
     * @var string $Code
     */
    public string $Code = '';
}