<?php
namespace inklabs\kommerce\EntityDTO;

class AbstractPaymentDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $amount;
}
