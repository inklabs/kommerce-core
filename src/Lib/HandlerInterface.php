<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextException;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface HandlerInterface
{
    /**
     * @param AuthorizationContextInterface $authorizationContext
     * @return void
     * @throws AuthorizationContextException
     */
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext);

    /**
     * @return ResponseInterface
     */
    public function handle();
}
