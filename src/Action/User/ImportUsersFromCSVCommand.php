<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\ActionInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class ImportUsersFromCSVCommand implements CommandInterface, ActionInterface
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
