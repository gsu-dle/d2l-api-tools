<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * Structure for the enrolled user’s information that the service exposes through the classlist API.
 * 
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Enrollment.ClasslistUser
 */
class ClasslistUserModel extends D2LModel
{
    /**
     * @var string $Identifier
     */
    public string $Identifier = '';

    /**
     * @var string $ProfileIdentifier
     */
    public string $ProfileIdentifier = '';

    /**
     * @var string $DisplayName
     */
    public string $DisplayName = '';

    /**
     * The back-end service can constrain the visibility of these properties through configuration of the Classlist 
     * tool. If these values are configured to be eligible to appear in the classlist for an org unit, then the API can 
     * return these values to the calling user (also assuming that the calling user’s role has permission to see those 
     * values).
     * 
     * @var string|null $UserName
     */
    public ?string $UserName = null;

    /**
     * The back-end service can constrain the visibility of these properties through configuration of the Classlist 
     * tool. If these values are configured to be eligible to appear in the classlist for an org unit, then the API can 
     * return these values to the calling user (also assuming that the calling user’s role has permission to see those 
     * values).
     * 
     * @var string|null $OrgDefinedId
     */
    public ?string $OrgDefinedId = null;

    /**
     * The back-end service can constrain the visibility of these properties through configuration of the Classlist 
     * tool. If these values are configured to be eligible to appear in the classlist for an org unit, then the API can 
     * return these values to the calling user (also assuming that the calling user’s role has permission to see those 
     * values).
     * 
     * @var string|null $Email
     */
    public ?string $Email = null;

    /**
     * @var string|null $FirstName
     */
    public ?string $FirstName = null;

    /**
     * @var string|null $LastName
     */
    public ?string $LastName = null;

    /**
     * @var int|null $RoleId
     */
    public ?int $RoleId = null;

    /**
     * The back-end service can constrain the visibility of these properties through configuration of the Classlist 
     * tool. If these values are configured to be eligible to appear in the classlist for an org unit, then the API can 
     * return these values to the calling user (also assuming that the calling user’s role has permission to see those 
     * values).
     * 
     * @var string|null $LastAccessed
     */
    public ?string $LastAccessed = null;

    /**
     * @var bool $IsOnline
     */
    public bool $IsOnline = false;
}
