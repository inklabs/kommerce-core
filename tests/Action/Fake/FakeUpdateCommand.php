<?php
namespace inklabs\kommerce\tests\Action\Fake;

use inklabs\kommerce\Lib\Command\CommandInterface;

class FakeUpdateCommand implements CommandInterface
{
    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var int */
    private $returnId;

    /**
     * @param string $name
     * @param string $email
     */
    public function __construct($name, $email)
    {
        $this->name = (string) $name;
        $this->email = (string) $email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getReturnId()
    {
        return $this->returnId;
    }

    /**
     * @param int $returnId
     */
    public function setReturnId($returnId)
    {
        $this->returnId = (int) $returnId;
    }
}
