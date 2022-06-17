<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\API\RichTextInputModel;
use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Section.SectionData
 */
class SectionDataModel extends D2LModel
{
    /**
     * @var int|null $SectionId
     */
    public ?int $SectionId = null;

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var string $Code Note that section code values have these limitations:
     * - They cannot be more than 50 characters in length.
     * - They may not contain these special characters: `\ : * ? “ ” < > | ‘  # , % &`
     */
    public string $Code = '';

    /**
     * @var RichTextInputModel $Description
     */
    public RichTextInputModel $Description;

    /**
     * @var array<int>|null $Enrollments This property contains a list of user IDs for the _explicitly enrolled_ users 
     * enrolled in the section.
     */
    public ?array $Enrollments = null;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, "Description") && is_object($values->Description)) {
            $this->Description = new RichTextInputModel(values: $values->Description);
        }
        if (property_exists($values, "Enrollments") && is_array($values->Enrollments)) {
            $this->Enrollments = [];
            foreach ($values->Enrollments as $userId) {
                $this->Enrollments[] = intval($userId);
            }
        }
        unset($values->Description, $values->Enrollments);

        parent::setValues(values: $values);
    }
}
