<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Lib\MapperInterface;

class CommandBus implements CommandBusInterface
{
    /** @var MapperInterface */
    private $mapper;

    public function __construct(MapperInterface $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * @param CommandInterface $command
     * @return void
     */
    public function execute(CommandInterface $command)
    {
        $handler = $this->mapper->getCommandHandler($command);
        $handler->handle($command);
    }
}
