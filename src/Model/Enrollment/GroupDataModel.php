<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;
use GAState\Tools\D2L\Model\API\RichTextInputModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Group.GroupData
 */
class GroupDataModel extends D2LModel
{
    /**
     * @var int|null $GroupId
     */
    public ?int $GroupId = null;

    /**
     * @var string $Name
     */
    public string $Name = '';

    /**
     * Note that group code values have these limitations:
     * - They cannot be more than 50 characters in length.
     * - They may not contain these special characters: `\ : * ? “ ” < > | ‘  # , % &`
     * @var string $Code
     */
    public string $Code = '';

    /**
     * @var RichTextInputModel|null $Description
     */
    public ?RichTextInputModel $Description = null;

    /**
     * @var array<int>|null $Enrollments
     */
    public ?array $Enrollments = null;


    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        if (property_exists($values, 'Description') && is_object($values->Description)) {
            $this->Description = new RichTextInputModel(values: $values->Description);
        }
        if (property_exists($values, 'Enrollments') && is_array($values->Enrollments)) {
            $this->Enrollments = [];
            foreach ($values->Enrollments as $orgUnitId) {
                $this->Enrollments[] = intval($orgUnitId);
            }
        }
        unset($values->Description, $values->Enrollments);

        parent::setValues(values: $values);
    }
}
