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
    /**
     * @param UuidInterface $userId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneByUserId(UuidInterface $userId);

    /**
     * @param string $sessionId
     * @return Cart
     * @throws EntityNotFoundException
     */
    public function findOneBySession($sessionId);

    /**
     * @param UuidInterface $cartItemId
     * @return CartItem
     * @throws EntityNotFoundException
     */
    public function getItemById(UuidInterface $cartItemId);
}
