<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CopyCartItemsCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $fromCartId;

    /** @var UuidInterface */
    private $toCartId;

    /**
     * @param string $fromCartId
     * @param string $toCartId
     */
    public function __construct($fromCartId, $toCartId)
    {
        $this->fromCartId = Uuid::fromString($fromCartId);
        $this->toCartId = Uuid::fromString($toCartId);
    }

    public function getFromCartId()
    {
        return $this->fromCartId;
    }

    public function getToCartId()
    {
        return $this->toCartId;
    }
}
