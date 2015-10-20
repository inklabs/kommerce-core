<?php
namespace inklabs\kommerce\Lib\Command;

use inklabs\kommerce\Lib\Mapper;

class CommandBus implements CommandBusInterface
{
    /** @var Mapper */
    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function execute(CommandInterface $command)
    {
        $handler = $this->mapper->getCommandHandler($command);
        $handler->handle($command);
    }
}
