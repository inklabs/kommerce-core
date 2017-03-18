<?php
namespace inklabs\kommerce\ActionResponse\Option;

use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\Lib\PricingInterface;

class GetOptionResponse
{
    /** @var OptionDTOBuilder */
    private $productDTOBuilder;

    /** @var PricingInterface */
    private $pricing;

    public function __construct(PricingInterface $pricing)
    {
        $this->pricing = $pricing;
    }

    public function setOptionDTOBuilder(OptionDTOBuilder $productDTOBuilder)
    {
        $this->productDTOBuilder = $productDTOBuilder;
    }

    public function getOptionDTO()
    {
        return $this->productDTOBuilder
            ->build();
    }

    public function getOptionDTOWithAllData()
    {
        return $this->productDTOBuilder
            ->withAllData($this->pricing)
            ->build();
    }
}
