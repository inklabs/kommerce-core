<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextException;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;

interface CommandHandlerInterface
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     * @return void
     * @throws AuthorizationContextException
     */
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext);
    public function handle();
}
