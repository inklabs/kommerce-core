<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextException;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;

interface HandlerInterface
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     * @return void
     * @throws AuthorizationContextException
     */
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext);
    public function handle();
}
