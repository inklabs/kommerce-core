<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\HandlerInterface;
use inklabs\kommerce\Lib\MapperInterface;

class CommandBus implements CommandBusInterface
{
    /** @var AuthorizationContextInterface */
    private $authorizationContext;

    /** @var MapperInterface */
    private $mapper;

    public function __construct(
        AuthorizationContextInterface $authorizationContext,
        MapperInterface $mapper
    ) {
        $this->authorizationContext = $authorizationContext;
        $this->mapper = $mapper;
    }

    /**
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command)
    {
        $handler = $this->mapper->getCommandHandler($command);
        if ($handler instanceof HandlerInterface) {
            $handler->verifyAuthorization($this->authorizationContext);
            $handler->handle();
        } else {
            // TODO: Remove when #98 is complete
            $handler->handle($command);
        }
    }
}
