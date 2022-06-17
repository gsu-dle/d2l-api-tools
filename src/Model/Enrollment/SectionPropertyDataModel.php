<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\API\RichTextInputModel;
use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Section.SectionPropertyData
 */
class SectionPropertyDataModel extends D2LModel
{
    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * @var RichTextInputModel $Description
     */
    public ?RichTextInputModel $Description = null;

    /**
     * @var SectionEnrollType|null $EnrollmentStyle
     */
    public ?SectionEnrollType $EnrollmentStyle = null;

    /**
     * @var int|null $EnrollmentQuantity
     */
    public ?int $EnrollmentQuantity = null;

    /**
     * @var bool|null $AutoEnroll
     */
    public ?bool $AutoEnroll = null;

    /**
     * @var bool|null $RandomizeEnrollments
     */
    public ?bool $RandomizeEnrollments = null;

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
        if (property_exists($values, "EnrollmentStyle") && is_numeric($values->EnrollmentStyle)) {
            $this->EnrollmentStyle = SectionEnrollType::from(value: intval($values->EnrollmentStyle));
        }
        unset($values->Description, $values->EnrollmentStyle);

        parent::setValues(values: $values);
    }
}
