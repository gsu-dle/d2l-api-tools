<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

/**
 * We categorize the ways that individual entities can enroll in groups using a number of different general types and 
 * use the term GRPENROLL_T to stand in for an appropriate integer value.
 * 
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#term-GRPENROLL_T
 */
enum GroupEnrollType: int
{
    case NotSet = -1;
    case NumberOfGroupsNoEnrollment = 0;
    case PeoplePerGroupAutoEnrollment = 1;
    case NumberOfGroupsAutoEnrollment = 2;
    case PeoplePerGroupSelfEnrollment = 3;
    case SelfEnrollmentNumberOfGroups = 4;
    case PeoplePerNumberOfGroupsSelfEnrollment = 5;
    case SingleUserMemberSpecificGroup = 6;
}
