<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCartItemCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\InputDTO\TextOptionValueDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddCartItemHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        CartItem::class,
        CartItemOptionProduct::class,
        CartItemOptionValue::class,
        CartItemTextOptionValue::class,
        Product::class,
        User::class,
        TaxRate::class,
        Option::class,
        OptionProduct::class,
        OptionValue::class,
        TextOption::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $cart = $this->dummyData->getCart();
        $this->persistEntityAndFlushClear([
            $cart,
            $product,
        ]);
        $quantity = 2;
        $command = new AddCartItemCommand(
            $cart->getId()->getHex(),
            $product->getId()->getHex(),
            $quantity
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $cartItem = $cart->getCartItems()[0];
        $this->assertEntitiesEqual($product, $cartItem->getProduct());
        $this->assertSame($quantity, $cartItem->getQuantity());
    }

    public function testHandleFull()
    {
        $product1 = $this->dummyData->getProduct();
        $option1 = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option1, $product1);
        $option2 = $this->dummyData->getOption();
        $optionValue = $this->dummyData->getOptionValue($option2);
        $textOption = $this->dummyData->getTextOption();
        $product = $this->dummyData->getProduct();
        $cart = $this->dummyData->getCart();
        $this->persistEntityAndFlushClear([
            $option1,
            $product1,
            $optionProduct,
            $option2,
            $optionValue,
            $textOption,
            $product,
            $cart,
        ]);
        $quantity = 2;
        $optionProductIds = [$optionProduct->getId()->getHex()];
        $optionValuesIds = [$optionValue->getId()->getHex()];
        $textOptionValue = 'Happy Birthday';
        $textOptionValueDTOs = [
            new TextOptionValueDTO(
                $textOption->getId()->getHex(),
                $textOptionValue
            )
        ];
        $command = new AddCartItemCommand(
            $cart->getId()->getHex(),
            $product->getId()->getHex(),
            $quantity,
            $optionProductIds,
            $optionValuesIds,
            $textOptionValueDTOs
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $cartItem = $cart->getCartItems()[0];
        $this->assertEntitiesEqual($product, $cartItem->getProduct());
        $this->assertSame($quantity, $cartItem->getQuantity());
        $this->assertSame($textOptionValue, $cartItem->getCartItemTextOptionValues()[0]->getTextOptionValue());
        $this->assertEntitiesEqual($textOption, $cartItem->getCartItemTextOptionValues()[0]->getTextOption());
        $this->assertEntitiesEqual($optionValue, $cartItem->getCartItemOptionValues()[0]->getOptionValue());
        $this->assertEntitiesEqual($optionProduct, $cartItem->getCartItemOptionProducts()[0]->getOptionProduct());
    }
}
