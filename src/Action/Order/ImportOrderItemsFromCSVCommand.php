<?php
namespace inklabs\kommerce\Action\Order;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class ImportOrderItemsFromCSVCommand implements CommandInterface
{
    /** @var string */
    private $fileName;

    /**
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->fileName = (string) $fileName;
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
