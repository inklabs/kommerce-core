<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;

interface HandlerInterface
{
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void;
}
