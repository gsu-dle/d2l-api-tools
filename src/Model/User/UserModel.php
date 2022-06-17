<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\User;

use GAState\Tools\D2L\Model\D2LModel;

class UserModel extends D2LModel
{
    public ?string $Identifier = null;
    public ?string $DisplayName = null;
    public ?string $EmailAddress = null;
    public ?string $OrgDefinedId = null;
    public ?string $ProfileBadgeUrl = null;
    public ?string $ProfileIdentifier = null;
}
