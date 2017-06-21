<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Cart findOneById(UuidInterface $id)
 */
interface CartRepositoryInterface extends RepositoryInterface
{
    public function findOneByUserId(UuidInterface $userId): Cart;
    public function findOneBySession(string $sessionId): Cart;
    public function getItemById(UuidInterface $cartItemId): CartItem;
}
