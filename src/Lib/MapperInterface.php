<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;

interface MapperInterface
{
    public function getCommandHandler(CommandInterface $command): CommandHandlerInterface;
    public function getQueryHandler(QueryInterface $query): QueryHandlerInterface;
}
