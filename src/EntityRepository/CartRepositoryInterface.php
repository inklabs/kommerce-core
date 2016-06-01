<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Lib\UuidInterface;

interface CartRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $uuid4
     * @return Cart
     */
    public function findOneByUuid(UuidInterface $uuid4);

    /**
     * @param UuidInterface $userId
     * @return Cart|null
     */
    public function findOneByUserId(UuidInterface $userId);

    /**
     * @param string $sessionId
     * @return Cart|null
     */
    public function findOneBySession($sessionId);
}
