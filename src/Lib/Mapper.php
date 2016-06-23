<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\AttachmentServiceInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\CatalogPromotionServiceInterface;
use inklabs\kommerce\Service\CouponServiceInterface;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderItemServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderServiceInterface;
use inklabs\kommerce\Service\Import\ImportPaymentServiceInterface;
use inklabs\kommerce\Service\Import\ImportUserServiceInterface;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\OptionServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\Service\TaxRateServiceInterface;
use inklabs\kommerce\Service\UserServiceInterface;
use ReflectionClass;

class Mapper implements MapperInterface
{
    /** @var ServiceFactory */
    private $serviceFactory;

    /** @var Pricing */
    private $pricing;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ServiceFactory $serviceFactory,
        Pricing $pricing,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->pricing = $pricing;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function getCommandHandler(CommandInterface $command)
    {
        $handlerClassName = $this->getCommandHandlerClassName($command);
        return $this->getHandler($handlerClassName);
    }

    public function getQueryHandler(QueryInterface $query)
    {
        $handlerClassName = $this->getQueryHandlerClassName($query);
        return $this->getHandler($handlerClassName);
    }

    /**
     * @param string $handlerClassName
     * @return null|object
     */
    public function getHandler($handlerClassName)
    {
        $reflection = new ReflectionClass($handlerClassName);

        $constructorParameters = [];
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $parameter) {
                $parameterClassName = $parameter->getClass()->getName();
                if ($parameterClassName === AttachmentServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getAttachmentService();
                } elseif ($parameterClassName === CartCalculatorInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCartCalculator();
                } elseif ($parameterClassName === CartServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCart();
                } elseif ($parameterClassName === CatalogPromotionServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCatalogPromotion();
                } elseif ($parameterClassName === CouponServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCoupon();
                } elseif ($parameterClassName === DTOBuilderFactoryInterface::class) {
                    $constructorParameters[] = $this->dtoBuilderFactory;
                } elseif ($parameterClassName === ImportUserServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getImportUser();
                } elseif ($parameterClassName === ImportOrderServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getImportOrder();
                } elseif ($parameterClassName === ImportOrderItemServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getImportOrderItem();
                } elseif ($parameterClassName === ImportPaymentServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getImportPayment();
                } elseif ($parameterClassName === InventoryServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getInventoryService();
                } elseif ($parameterClassName === ImageServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getImageService();
                } elseif ($parameterClassName === OptionServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getOption();
                } elseif ($parameterClassName === OrderServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getOrder();
                } elseif ($parameterClassName === ProductServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getProduct();
                } elseif ($parameterClassName === ShipmentGatewayInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getShipmentGateway();
                } elseif ($parameterClassName === TagServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getTagService();
                } elseif ($parameterClassName === TaxRateServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getTaxRate();
                } elseif ($parameterClassName === UserServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getUser();
                }
            }
        }

        $handler = null;

        if (! empty($constructorParameters)) {
            $handler = $reflection->newInstanceArgs($constructorParameters);
        } else {
            $handler = $reflection->newInstance();
        }

        return $handler;
    }

    /**
     * @param CommandInterface $command
     * @return string
     */
    private function getCommandHandlerClassName($command)
    {
        $className = get_class($command);
        $className = str_replace('\\Action\\', '\\ActionHandler\\', $className);
        $pieces = explode('\\', $className);

        $baseName = array_pop($pieces);
        $handlerBaseName = substr($baseName, 0, -7) . 'Handler';

        $pieces[] = $handlerBaseName;

        return implode('\\', $pieces);
    }

    /**
     * @param QueryInterface
     * @return string
     */
    private function getQueryHandlerClassName($query)
    {
        $className = get_class($query);
        $className = str_replace('\\Action\\', '\\ActionHandler\\', $className);
        $pieces = explode('\\', $className);

        $baseName = array_pop($pieces);
        $handlerBaseName = substr($baseName, 0, -5) . 'Handler';

        $pieces[] = $handlerBaseName;

        return implode('\\', $pieces);
    }
}
