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
    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void;

    /**
     * @todo Break this into separate command and query handler interfaces
     * @return ResponseInterface
     */
    public function handle();
}
