<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;

/**
 * @method Cart findOneById($id)
 */
interface CartRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $userId
     * @return Cart|null
     */
    public function findOneByUser($userId);

    /**
     * @param string $sessionId
     * @return Cart|null
     */
    public function findOneBySession($sessionId);
}
