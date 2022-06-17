<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * This block describes a user role that you can assign to an enrolled user.
 * 
 * @package GAState\Tools\D2L\Model\User
 * @access public
 * @see https://docs.valence.desire2learn.com/res/user.html#User.Role
 */
class UserRoleModel extends D2LModel
{
    /**
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * @var string $DisplayName
     */
    public string $DisplayName = '';

    /**
     * @var string|null $Code
     */
    public ?string $Code = null;

    /**
     * @var string $Description
     */
    public string $Description = '';

    /**
     * @var string $RoleAlias
     */
    public string $RoleAlias = '';

    /**
     * @var bool $IsCascading
     */
    public bool $IsCascading = false;

    /**
     * @var bool $AccessFutureCourses
     */
    public bool $AccessFutureCourses = false;

    /**
     * @var bool $AccessInactiveCourses
     */
    public bool $AccessInactiveCourses = false;

    /**
     * @var bool $AccessPastCourses
     */
    public bool $AccessPastCourses = false;

    /**
     * @var bool $ShowInGrades
     */
    public bool $ShowInGrades = false;

    /**
     * @var bool $ShowInUserProgress
     */
    public bool $ShowInUserProgress = false;

    /**
     * @var bool $InClassList
     */
    public bool $InClassList = false;
}
