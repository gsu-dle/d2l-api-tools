<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\Enrollment;

use GAState\Tools\D2L\Model\D2LModel;

/**
 * @package GAState\Tools\D2L\Model\Enrollment
 * @access public
 * @see https://docs.valence.desire2learn.com/res/enroll.html#Enrollment.RoleInfo
 */
class RoleInfoModel extends D2LModel
{
    /**
     * @var int $Id
     */
    public int $Id = 0;

    /**
     * @var string|null $Code
     */
    public ?string $Code = null;

    /**
     * @var string $Name
     */
    public string $Name = '';
}
