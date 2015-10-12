<?php
namespace inklabs\kommerce\Action;

use inklabs\kommerce\Lib\Command\CommandInterface;

abstract class AbstractIdCommand implements CommandInterface
{
    /** @var int */
    private $id;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
