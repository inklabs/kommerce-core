<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Lib\Command\CommandInterface;

class CreateTagCommand implements CommandInterface
{
    public $name;
    public $code;
    public $description;
    public $isActive;
    public $isVisible;
    public $sortOrder;

    public function __construct(array $properties)
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }
    }
}
