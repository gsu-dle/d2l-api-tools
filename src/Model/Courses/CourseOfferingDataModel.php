<?php
/**
 * D2L Api Package
 * Course OFfering Data Model
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
use GAState\Tools\D2L\Model\Courses\CourseBasicUnitDataModel;
use GAState\Tools\D2L\Model\API\RichTextInputModel;

/**
 * This block describes a Block used to create a course
 * 
 * @category PHP
 * @package  GAState\Tools\D2L\Model\CourseDataModel
 * @access   public
 * @author   Melody Kimball <mforest@gsu.edu>
 * @author   Jeb Barger <jbarger@gsu.edu>
 * @license  https://github.com/gsu-dle/d2l-api-tools/blob/main/LICENSE BSD Licence
 * @link     https://github.com/gsu-dle/d2l-api-tools
 * @see      https://docs.valence.desire2learn.com/res/course.html#Course.CreateCourseOffering
 */
class CourseOfferingDataModel extends D2LModel
{
    /**
     * Course Identifier
     *
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * Course Name
     * 
     * @var string $Name
     */
    public string $Name = '';

    /**
     * Course Code
     * 
     * @var string $Code
     */
    public string $Code = '';

    /**
     * Course is Active
     * 
     * @var bool|null $IsActive
     */
    public bool|null $IsActive = null;

    /**
     * Course PAth
     * 
     * @var string|null $Path
     */
    public string|null $Path = null;

    /**
     * Course Start Date
     * 
     * @var string|null $StartDate
     */
    public string|null $StartDate = null;

    /**
     * Course End Date
     * 
     * @var string|null $EndDate
     */
    public string|null $EndDate = null;

    /**
     * Course Template
     * 
     * @var CourseBasicUnitDataModel|null $CourseTemplate
     */
    public CourseBasicUnitDataModel|null $CourseTemplate = null;

    /**
     * Course Semester
     * 
     * @var CourseBasicUnitDataModel $Semester
     */
    public CourseBasicUnitDataModel|null $Semester = null;

     /**
      * Course Department

      * @var CourseBasicUnitDataModel $Department
      */
    public CourseBasicUnitDataModel $Department;

    /**
     * Course Description
     * 
     * @var RichTextInputModel|null $Description
     */
    public RichTextInputModel|null $Description = null;

    /**
     * Course Can Self Register
     * 
     * @var bool|null $CanSelfRegister
     */
    public bool|null $CanSelfRegister = null;

   
}
