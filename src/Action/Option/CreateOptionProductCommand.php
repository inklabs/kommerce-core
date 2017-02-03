<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\EntityDTO\OptionProductDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateOptionProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionProductId;

    /** @var UuidInterface */
    private $optionId;

    /** @var UuidInterface */
    private $productId;

    /** @var OptionProductDTO */
    private $optionProductDTO;

    /**
     * @param string $optionId
     * @param string $productId
     * @param OptionProductDTO $optionProductDTO
     */
    public function __construct($optionId, $productId, OptionProductDTO $optionProductDTO)
    {
        $this->optionProductId = Uuid::uuid4();
        $this->optionId = Uuid::fromString($optionId);
        $this->productId = Uuid::fromString($productId);
        $this->optionProductDTO = $optionProductDTO;
    }

    public function getOptionId()
    {
        return $this->optionId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getOptionProductDTO()
    {
        return $this->optionProductDTO;
    }

    public function getOptionProductId()
    {
        return $this->optionProductId;
    }
}
