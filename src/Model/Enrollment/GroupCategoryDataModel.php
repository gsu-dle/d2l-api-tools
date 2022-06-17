<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\API\RichTextInputModel;
use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Group.GroupCategoryData
 */
class GroupCategoryDataModel extends D2LModel
{
    /**
     * @var int $GroupCategoryId
     */
    public int $GroupCategoryId = 0;

    /**
     * @var string $Name 
     */
    public string $Name = '';

    /**
     * @var RichTextInputModel $Description Note that this property uses the `RichTextInput` structure type.
     */
    public RichTextInputModel $Description;

    /**
     * @var GroupEnrollType $EnrollmentStyle If you specify an `EnrollmentStyle` of `SingleUserMemberSpecificGroup` 
     * (added as of LE v1.10 API), values set for `NumberOfGroups` and `MaxUsersPerGroup` will be ignored. This style of
     * group creates a single group per user enrolled in the orgunit.
     */
    public GroupEnrollType $EnrollmentStyle = GroupEnrollType::NotSet;

    /**
     * @var int|null $EnrollmentQuantity This property may appear, but is deprecated, and you should use 
     * `MaxUsersPerGroup` as a working value instead. If you provide a non-null value for this property, the service 
     * will ignore any values you provide for `NumberOfGroups` and `MaxUsersPerGroup`.
     */
    public ?int $EnrollmentQuantity = null;

    /**
     * @var bool $AutoEnroll
     */
    public bool $AutoEnroll = false;

    /**
     * @var bool $RandomizeEnrollments
     */
    public bool $RandomizeEnrollments = false;

    /**
     * @var int|null $NumberOfGroups If you don’t provide a value for `EnrollmentQuantity`, then you should provide a 
     * non-null value for this property when creating a group category of one of these **types**:
     * - `NumberOfGroupsNoEnrollment` (0)
     * - `NumberOfGroupsAutoEnrollment` (2)
     * - `SelfEnrollmentNumberOfGroups` (4)
     * - `PeoplePerNumberOfGroupsSelfEnrollment` (5)
     */
    public ?int $NumberOfGroups = null;

    /**
     * @var int|null $MaxUsersPerGroup If you don’t provide a value for `EnrollmentQuantity`, then you should provide a 
     * non-null value for this property when creating a group category of one of these **types**:
     * - `PeoplePerGroupAutoEnrollment` (1)
     * - `PeoplePerGroupSelfEnrollment` (3)
     * - `PeoplePerNumberOfGroupsSelfEnrollment` (5)
     */
    public ?int $MaxUsersPerGroup = null;

    /**
     * @var bool $AllocateAfterExpiry You should only set `AllocateAfterExpiry` to true if a value is provided for 
     * `SelfEnrollmentExpiryDate`. You should only set these values when you create a group category with one of these 
     * **types**:
     * - `PeoplePerGroupAutoEnrollment` (1)
     * - `PeoplePerGroupSelfEnrollment` (3)
     * - `PeoplePerNumberOfGroupsSelfEnrollment` (5)
     */
    public bool $AllocateAfterExpiry = false;

    /**
     * @var string|null $SelfEnrollmentExpiryDate You should only set `AllocateAfterExpiry` to true if a value is 
     * provided for `SelfEnrollmentExpiryDate`. You should only set these values when you create a group category with 
     * one of these **types**:
     * - `PeoplePerGroupAutoEnrollment` (1)
     * - `PeoplePerGroupSelfEnrollment` (3)
     * - `PeoplePerNumberOfGroupsSelfEnrollment` (5)
     */
    public ?string $SelfEnrollmentExpiryDate = null;

    /**
     * @var string|null $GroupPrefix If you specify a `GroupPrefix`, the back-end service will prepend it to both the 
     * `GroupName` and the `GroupCode`; if you don’t provide a value, the service will use default prefix values 
     * instead.
     */
    public ?string $GroupPrefix = null;

    /**
     * @var int|null $RestrictedByOrgUnitId
     */
    public ?int $RestrictedByOrgUnitId = null;

    /**
     * @var array<int>|null $Groups This property contains a list of Group IDs for all the groups that belong to this 
     * group category.
     */
    public ?array $Groups = null;

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
        if (property_exists($values, 'EnrollmentStyle') && is_numeric($values->EnrollmentStyle)) {
            $this->EnrollmentStyle = GroupEnrollType::from(intval($values->EnrollmentStyle));
        }
        if (property_exists($values, 'Groups') && is_array($values->Groups)) {
            $this->Groups = [];
            foreach ($values->Groups as $groupId) {
                $this->Groups[] = intval($groupId);
            }
        }
        unset($values->Description, $values->EnrollmentStyle, $values->Groups);

        parent::setValues(values: $values);
    }
}
