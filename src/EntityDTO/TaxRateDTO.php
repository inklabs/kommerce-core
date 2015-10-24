<?php
namespace inklabs\kommerce\EntityDTO;

class TaxRateDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $state;
    public $zip5;
    public $zip5From;
    public $zip5To;
    public $rate;
    public $applyToShipping;
}
