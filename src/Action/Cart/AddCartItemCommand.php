<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class AddCartItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $cartItemId;

    /** @var UuidInterface */
    private $cartId;

    /** @var UuidInterface */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var UuidInterface[] */
    private $optionProductIds = [];

    /** @var UuidInterface[] */
    private $optionValueIds = [];

    /** @var TextOptionValueDTO[] */
    private $textOptionValueDTOs = [];

    /**
     * @param string $cartId
     * @param string $productId
     * @param int $quantity
     * @param string[]|null $optionProductIds
     * @param string[]|null $optionValuesIds
     * @param TextOptionValueDTO[]|null $textOptionValueDTOs
     */
    public function __construct(
        $cartId,
        $productId,
        $quantity,
        array $optionProductIds = null,
        array $optionValuesIds = null,
        array $textOptionValueDTOs = null
    ) {
        $this->cartItemId = Uuid::uuid4();
        $this->cartId = Uuid::fromString($cartId);
        $this->productId = Uuid::fromString($productId);
        $this->quantity = (int) $quantity;

        if ($optionProductIds !== null) {
            $this->setOptionProductIds($optionProductIds);
        }

        if ($optionValuesIds !== null) {
            $this->setOptionValueIds($optionValuesIds);
        }

        if ($textOptionValueDTOs !== null) {
            $this->setTextOptionValueDTOs($textOptionValueDTOs);
        }
    }

    public function getCartItemId()
    {
        return $this->cartItemId;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getOptionProductIds()
    {
        return $this->optionProductIds;
    }

    public function getOptionValueIds()
    {
        return $this->optionValueIds;
    }

    public function getTextOptionValueDTOs()
    {
        return $this->textOptionValueDTOs;
    }

    /**
     * @param string[] $optionProductIds
     */
    private function setOptionProductIds(array $optionProductIds)
    {
        foreach ($optionProductIds as $optionProductId) {
            $this->optionProductIds[] = Uuid::fromString($optionProductId);
        }
    }

    /**
     * @param string[] $optionValueIds
     */
    private function setOptionValueIds(array $optionValueIds)
    {
        foreach ($optionValueIds as $optionValueId) {
            $this->optionValueIds[] = Uuid::fromString($optionValueId);
        }
    }

    /**
     * @param TextOptionValueDTO[] $textOptionValueDTOs
     */
    private function setTextOptionValueDTOs(array $textOptionValueDTOs)
    {
        foreach ($textOptionValueDTOs as $textOptionValueDTO) {
            $this->addTextOptionValueDTO($textOptionValueDTO);
        }
    }

    private function addTextOptionValueDTO(TextOptionValueDTO $textOptionValueDTO)
    {
        $this->textOptionValueDTOs[] = $textOptionValueDTO;
    }
}
