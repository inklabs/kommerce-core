<?php
namespace inklabs\kommerce\Action\Product;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = Uuid::fromString($id);
    }

    public function getProductId()
    {
        return $this->id;
    }
}
