<?php
namespace inklabs\kommerce\EntityDTO;

class OptionProductDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $sortOrder;

    /** @var ProductDTO */
    public $product;

    /** @var OptionDTO */
    public $option;
}
