<?php
/**
 * D2L Api Package
 * Create Course Data Model
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
use GAState\Tools\D2L\Model\API\RichTextInputModel;

/**
 * Create Course Data Model
 *
 * PHP version 8.2
 *
 * @category PHP
 * @package  GAState\Tools\D2L\Model\CourseDataModel
 * @author   Melody Kimball <mforest@gsu.edu>
 * @author   Jeb Barger <jbarger@gsu.edu>
 * @license  https://github.com/gsu-dle/d2l-api-tools/blob/main/LICENSE BSD Licence
 * @link     https://github.com/gsu-dle/d2l-api-tools
 * @see      https://docs.valence.desire2learn.com/res/course.html#Course.CreateCourseOffering
 */

class CreateCourseDataModel extends D2LModel
{
    /**
     * Name
     * 
     * @var string $Name Name
     */
    public string $Name = '';

    /**
     * Code
     * 
     * @var string $Code
     */
    public string $Code = '';

    /**
     * Path
     * 
     * @var string $Path
     */
    public string $Path = '';

    /**
     * Course Template ID
     * 
     * @var int|null $CourseTemplateId
     */
    public int|null $CourseTemplateId = null;

    /**
     * Semester Id
     * 
     * @var int $SemesterId
     */
    public int|null $SemesterId = null;

    /**
     * Start Date
     * 
     * @var string|null $StartDate
     */
    public string|null $StartDate = null;

    /**
     * End Date
     * 
     * @var string|null $EndDate
     */
    public string|null $EndDate = null;

    /**
     * Locale ID
     * 
     * @var int|null $LocaleId
     */
    public int|null $LocaleId = null;

    /**
     * Force Locale
     * 
     * @var bool $ForceLocale
     */
    public bool $ForceLocale = false;

    /**
     * Show Address Book
     * 
     * @var bool $ShowAddressBook
     */
    public bool $ShowAddressBook = false;

    /**
     * Description
     * 
     * @var RichTextInputModel|null $Description
     */
    public RichTextInputModel|null $Description = null;

    /**
     * Can Self Register
     * 
     * @var bool $CanSelfRegister
     */
    public bool $CanSelfRegister = false;

    /**
     * Set Variables to make course
     * 
     * @param string                  $Name             Course Name
     * @param string                  $Code             Code
     * @param int                     $CourseTemplateId Template ID
     * @param string                  $Path             PAth
     * @param string|null             $StartDate        Start Date
     * @param string|null             $EndDate          End Date
     * @param int|null                $SemesterId       Semester ID
     * @param int|null                $LocaleId         Locale ID
     * @param bool                    $ForceLocale      Force Locale ID
     * @param bool                    $ShowAddressBook  Show Address Book
     * @param RichTextInputModel|null $Description      Description
     * 
     * @return void
     * 
     * @see https://docs.valence.desire2learn.com/res/course.html#post--d2l-api-lp-(version)-courses-
     */
    public function setVariables(
        string $Name,
        string $Code,
        int $CourseTemplateId,
        string $Path = '',
        ?string $StartDate = null,
        ?string $EndDate = null,
        ?int $SemesterId = null,
        ?int $LocaleId = null,
        bool $ForceLocale = false,
        bool $ShowAddressBook = false,
        ?RichTextInputModel $Description = null
    ) : void {

        $this->Name = $Name;
        $this->Code = $Code;
        $this->CourseTemplateId = $CourseTemplateId;
        $this->Path = $Path;
        $this->StartDate = $StartDate;
        $this->EndDate = $EndDate;
        $this->SemesterId = $SemesterId;
        $this->LocaleId = $LocaleId;
        $this->ForceLocale = $ForceLocale;
        $this->ShowAddressBook = $ShowAddressBook;

        if (is_null($Description)) {
            $Description =new RichTextInputModel();
            $Description->Type = '';
            $Description->Content = '';
        }

        $this->Description = $Description;
    }
}
