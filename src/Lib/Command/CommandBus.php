<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Event\ReleaseEventsInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\HandlerInterface;
use inklabs\kommerce\Lib\MapperInterface;

class CommandBus implements CommandBusInterface
{
    /** @var AuthorizationContextInterface */
    private $authorizationContext;

    /** @var MapperInterface */
    private $mapper;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        AuthorizationContextInterface $authorizationContext,
        MapperInterface $mapper,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->authorizationContext = $authorizationContext;
        $this->mapper = $mapper;
        $this->eventDispatcher = $eventDispatcher;
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
            $this->dispatchEvents($handler);
        } else {
            // TODO: Remove when #98 is complete
            $handler->handle($command);
        }
    }

    private function dispatchEvents(HandlerInterface $handler)
    {
        if ($handler instanceof ReleaseEventsInterface) {
            $this->eventDispatcher->dispatchEvents($handler->releaseEvents());
        }
    }
}
