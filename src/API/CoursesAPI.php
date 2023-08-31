<?php
/**
 * D2L Api Package
 * Courses API Functions
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

namespace GAState\Tools\D2L\API;

use GAState\Tools\D2L\Exception\D2LExpectedObjectException;
use GAState\Tools\D2L\Model\Courses\CourseOfferingDataModel;
use GAState\Tools\D2L\Model\Courses\CourseBasicUnitDataModel;
use GAState\Tools\D2L\Model\Courses\CreateCourseDataModel;
use GAState\Tools\D2L\Model\API\RichTextInputModel;


/**
 * With the courses resource you can retrieve information about existing courses,
 * modify or remove them, and create new courses.
 * 
 * @category PHP
 * @package  GAState\Tools\D2L\API
 * @access   public
 * @author   Melody Kimball <mforest@gsu.edu>
 * @author   Jeb Barger <jbarger@gsu.edu>
 * @license  https://github.com/gsu-dle/d2l-api-tools/blob/main/LICENSE BSD Licence
 * @link     https://github.com/gsu-dle/d2l-api-tools
 * @see      https://docs.valence.desire2learn.com/res/course.html
 */
class CoursesAPI extends D2LAPI
{
    /**
     * Identifier
     *
     * @var array<string> $basicUnitElements
     */
    public $basicUnitElements = ["Department", "Semester", "CourseTemplate"];

    /**
     * Get Course Information
     * 
     * @param int $orgUnitId Org Unit Id of the Course
     * 
     * @return CourseOfferingDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/course.html#get--d2l-api-lp-(version)-courses-(orgUnitId)
     */
    public function getCourse(
        int $orgUnitId
    ): CourseOfferingDataModel {

        $response = $this->callAPI(
            product: 'lp',
            action: 'GET',
            route: "/courses/{$orgUnitId}"
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        foreach ($this->basicUnitElements as $value) {
            $response->data->{$value} = $this->setCourseBasicUnitValues(
                $value, 
                $response->data
            );
        }

        $response->data->Description = $this->setRichTextValues(
            "Description",
            $response->data
        );

        return new CourseOfferingDataModel(values: $response->data);
    }
    /**
     * Create New Course
     * 
     * @param CreateCourseDataModel $newCourse Course Information
     * 
     * @return CourseOfferingDataModel
     * 
     * @see https://docs.valence.desire2learn.com/res/course.html#post--d2l-api-lp-(version)-courses-
     */
    public function createCourse(
        CreateCourseDataModel $newCourse
    ) {

        $response = $this->callAPI(
            product: 'lp',
            action: 'POST',
            route: "/courses/",
            data: $newCourse
        );

        if (!is_object($response->data)) {
            throw new D2LExpectedObjectException(response: $response);
        }

        foreach ($this->basicUnitElements as $value) {
            $response->data->$value= $this->setCourseBasicUnitValues(
                $value, 
                $response->data
            );
        }

        $response->data->Description = $this->setRichTextValues(
            "Description",
            $response->data
        );

        return new CourseOfferingDataModel(values: $response->data);
    } 

    /**
     * Create New Course
     * 
     * @param string $element Course Elements
     * @param object $values  Values of Course Elements
     * 
     * @return CourseBasicUnitDataModel|null
     */
    public function setCourseBasicUnitValues(
        string $element, 
        object $values
    ): CourseBasicUnitDataModel|null {
        $returnCourseBasicUnit = null;

        if (property_exists($values, $element) && is_object($values->$element)) {
            $returnCourseBasicUnit = new CourseBasicUnitDataModel(
                values: $values->$element
            );
        }
        return $returnCourseBasicUnit;
    }

     /**
      * Create New Course
      * 
      * @param string $element Course Elements
      * @param object $values  Values of Course Elements
      * 
      * @return RichTextInputModel|null
      */
    public function setRichTextValues(
        string $element, 
        object $values
    ): RichTextInputModel|null {

        $returnRichTextModel = null;

        if (property_exists($values, $element) && is_object($values->$element)) {
            $returnRichTextModel = new RichTextInputModel(values: $values);
        } 
        return $returnRichTextModel;
    }
}