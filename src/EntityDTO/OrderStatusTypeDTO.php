<?php
namespace inklabs\kommerce\EntityDTO;

class OrderStatusTypeDTO extends AbstractIntegerTypeDTO
{
    /** @var bool */
    public $isPending;

    /** @var bool */
    public $isProcessing;

    /** @var bool */
    public $isPartiallyShipped;

    /** @var bool */
    public $isShipped;

    /** @var bool */
    public $isComplete;

    /** @var bool */
    public $isCanceled;
}
