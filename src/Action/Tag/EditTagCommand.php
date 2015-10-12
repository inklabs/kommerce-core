<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Command\CommandInterface;

class EditTagCommand implements CommandInterface
{
    public $id;
    public $name;
    public $code;
    public $description;
    public $isActive;
    public $isVisible;
    public $sortOrder;

    public function __construct($id, array $properties)
    {
        foreach ($properties as $name => $value) {
            $this->$name = $value;
        }

        $this->id = (int) $id;
    }
}
