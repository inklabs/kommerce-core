<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;

/**
 * @method Cart find($id)
 */
interface CartRepositoryInterface extends AbstractRepositoryInterface
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
