<?php
namespace inklabs\kommerce\Action\Coupon;

use inklabs\kommerce\Lib\Command\CommandInterface;

final class DeleteCouponCommand implements CommandInterface
{
    /** @var int */
    private $id;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
