<?php
namespace inklabs\kommerce\EntityDTO;

class InventoryTransactionTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isMove;

    /** @var bool */
    public $isHold;

    /** @var bool */
    public $isNewProducts;

    /** @var bool */
    public $isShipped;

    /** @var bool */
    public $isReturned;

    /** @var bool */
    public $isPromotion;

    /** @var bool */
    public $isDamaged;

    /** @var bool */
    public $isShrinkage;
}
