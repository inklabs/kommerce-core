<?php
namespace inklabs\kommerce\Action\Option\Query;

use inklabs\kommerce\EntityDTO\Builder\OptionDTOBuilder;
use inklabs\kommerce\Lib\Pricing;

class GetOptionResponse implements GetOptionResponseInterface
{
    /** @var OptionDTOBuilder */
    private $productDTOBuilder;

    /** @var Pricing */
    private $pricing;

    public function __construct(Pricing $pricing)
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
