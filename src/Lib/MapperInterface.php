<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

interface MapperInterface
{
    /**
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     */
    public function getCommandHandler(CommandInterface $command);

    /**
     * @param QueryInterface $query
     * @return QueryHandlerInterface
     */
    public function getQueryHandler(QueryInterface $query);
}
