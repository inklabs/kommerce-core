<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class ImportPaymentsFromCSVCommand implements CommandInterface
{
    /** @var string */
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = (string) $fileName;
    }

    public function getFileName(): string
    {
        return $this->fileName;
    }
}
