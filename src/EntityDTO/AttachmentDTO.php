<?php
namespace inklabs\kommerce\EntityDTO;

class AttachmentDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var bool */
    public $isVisible;

    /** @var bool */
    public $isLocked;

    /** @var string */
    public $uri;

    /** @var OrderItemDTO[] */
    public $orderItems = [];
}
