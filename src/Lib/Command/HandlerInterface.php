<?php
namespace inklabs\kommerce\Lib\Command;

interface HandlerInterface
{
    public function handle(CommandInterface $command);
}
