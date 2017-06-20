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

    public function __construct(string $optionId, string $productId, OptionProductDTO $optionProductDTO)
    {
        $this->optionProductId = Uuid::uuid4();
        $this->optionId = Uuid::fromString($optionId);
        $this->productId = Uuid::fromString($productId);
        $this->optionProductDTO = $optionProductDTO;
    }

    public function getOptionId(): UuidInterface
    {
        return $this->optionId;
    }

    public function getProductId(): UuidInterface
    {
        return $this->productId;
    }

    public function getOptionProductDTO(): OptionProductDTO
    {
        return $this->optionProductDTO;
    }

    public function getOptionProductId(): UuidInterface
    {
        return $this->optionProductId;
    }
}
