<?php
namespace inklabs\kommerce\ActionHandler\Order;

use inklabs\kommerce\Action\Order\CreateOrderFromCartCommand;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\Warehouse;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateOrderFromCartHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        User::class,
        Product::class,
        Option::class,
        OptionProduct::class,
        Tag::class,
        Image::class,
        Cart::class,
        CartItem::class,
        CartItemOptionProduct::class,
        Order::class,
        OrderItem::class,
        OrderItemOptionProduct::class,
        AbstractPayment::class,
        InventoryLocation::class,
        InventoryTransaction::class,
        Warehouse::class,
        TaxRate::class,
    ];

    public function testHandleWithFullIntegration()
    {
        $cart = $this->setupDBCart();
        $dtoBuilderFactory = $this->getDTOBuilderFactory();

        $creditCardDTO = $dtoBuilderFactory
            ->getCreditCardDTOBuilder($this->dummyData->getCreditCard())->build();

        $shippingAddressDTO = $dtoBuilderFactory
            ->getOrderAddressDTOBuilder($this->dummyData->getOrderAddress())->build();

        $billingAddressDTO = $dtoBuilderFactory
            ->getOrderAddressDTOBuilder($this->dummyData->getOrderAddress())->build();

        $command = new CreateOrderFromCartCommand(
            $cart->getId()->getHex(),
            $cart->getUser()->getId()->getHex(),
            '10.0.0.1',
            $creditCardDTO,
            $shippingAddressDTO,
            $billingAddressDTO
        );

        $this->dispatchCommand($command);

        $order = $this->getRepositoryFactory()->getOrderRepository()->findOneById(
            $command->getOrderId()
        );

        $this->assertTrue($order instanceof Order);
        $this->assertTrue($order->getPayments()[0] instanceof AbstractPayment);

        $this->setExpectedException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getCartRepository()->findOneById($cart->getId());
    }

    protected function setupDBCart()
    {
        $user = $this->dummyData->getUser();
        $product = $this->dummyData->getProduct();
        $option = $this->dummyData->getOption();
        $product2 = $this->dummyData->getProduct();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product2);
        $cartItemOptionProduct = $this->dummyData->getCartItemOptionProduct($optionProduct);
        $cartItem = $this->dummyData->getCartItem($product);
        $cartItem->addCartItemOptionProduct($cartItemOptionProduct);

        $cart = $this->dummyData->getCart();
        $cart->setUser($user);
        $cart->addCartItem($cartItem);

        $warehouse = $this->dummyData->getWarehouse();
        $inventoryLocation = $this->dummyData->getInventoryLocation($warehouse);

        $inventoryTransaction1 = $this->dummyData->getInventoryTransaction($inventoryLocation, $product);
        $inventoryTransaction2 = $this->dummyData->getInventoryTransaction($inventoryLocation, $product2);

        $this->entityManager->persist($user);
        $this->entityManager->persist($product);
        $this->entityManager->persist($option);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($optionProduct);
        $this->entityManager->persist($cart);

        $this->entityManager->persist($warehouse);
        $this->entityManager->persist($inventoryLocation);
        $this->entityManager->persist($inventoryTransaction1);
        $this->entityManager->persist($inventoryTransaction2);
        $this->entityManager->flush();

        return $cart;
    }
}
