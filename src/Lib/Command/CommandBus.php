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

    public function execute(CommandInterface $command): void
    {
        $handler = $this->mapper->getCommandHandler($command);
        $handler->verifyAuthorization($this->authorizationContext);
        $handler->handle();
        $this->dispatchEvents($handler);
    }

    private function dispatchEvents(HandlerInterface $handler): void
    {
        if ($handler instanceof ReleaseEventsInterface) {
            $this->eventDispatcher->dispatchEvents($handler->releaseEvents());
        }
    }
}
