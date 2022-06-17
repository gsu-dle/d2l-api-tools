<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

/**
 * We categorize the ways that individual entities can enroll into sections using a number of different general types 
 * and use the term SECTENROLL_T to stand in for an appropriate integer value.
 * 
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#term-SECTENROLL_T
 */
enum SectionEnrollType: int
{
    case NotSet = -1;
    case PeoplePerSectionAutoEnrollment = 0;
    case NumberOfSectionsAutoEnrollment = 1;
}
