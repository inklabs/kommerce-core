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

    public function __construct(string $fromCartId, string $toCartId)
    {
        $this->fromCartId = Uuid::fromString($fromCartId);
        $this->toCartId = Uuid::fromString($toCartId);
    }

    public function getFromCartId(): UuidInterface
    {
        return $this->fromCartId;
    }

    public function getToCartId(): UuidInterface
    {
        return $this->toCartId;
    }
}
