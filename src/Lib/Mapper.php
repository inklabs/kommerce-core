<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartPriceRuleRepositoryInterface;
use inklabs\kommerce\EntityRepository\CartRepositoryInterface;
use inklabs\kommerce\EntityRepository\CatalogPromotionRepositoryInterface;
use inklabs\kommerce\EntityRepository\ConfigurationRepositoryInterface;
use inklabs\kommerce\EntityRepository\CouponRepositoryInterface;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductQuantityDiscountRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\EntityRepository\ShipmentTrackerRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\EntityRepository\UserTokenRepositoryInterface;
use inklabs\kommerce\EntityRepository\WarehouseRepositoryInterface;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\AttachmentServiceInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderItemServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderServiceInterface;
use inklabs\kommerce\Service\Import\ImportPaymentServiceInterface;
use inklabs\kommerce\Service\Import\ImportUserServiceInterface;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\Service\UserServiceInterface;
use ReflectionClass;

class Mapper implements MapperInterface
{
    /** @var RepositoryFactory */
    private $repositoryFactory;

    /** @var ServiceFactory */
    private $serviceFactory;

    /** @var Pricing */
    private $pricing;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        RepositoryFactory $repositoryFactory,
        ServiceFactory $serviceFactory,
        Pricing $pricing,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->serviceFactory = $serviceFactory;
        $this->pricing = $pricing;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function getCommandHandler(CommandInterface $command)
    {
        $handlerClassName = $this->getCommandHandlerClassName($command);
        return $this->getHandler($handlerClassName, $command);
    }

    public function getQueryHandler(QueryInterface $query)
    {
        $handlerClassName = $this->getQueryHandlerClassName($query);
        return $this->getHandler($handlerClassName, $query);
    }

    /**
     * @param string $handlerClassName
     * @param ActionInterface
     * @return null|object
     */
    public function getHandler($handlerClassName, $action)
    {
        $reflection = new ReflectionClass($handlerClassName);

        $constructorParameters = [];
        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $key => $parameter) {
                if ($key === 0 && $action instanceof ActionInterface) {
                    $constructorParameters[] = $action;
                    continue;
                }

                $parameterClassName = $parameter->getClass()->getName();
                if ($parameterClassName === AttachmentRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getAttachmentRepository();
                } elseif ($parameterClassName === AttributeRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getAttributeRepository();
                } elseif ($parameterClassName === AttributeValueRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getAttributeValueRepository();
                } elseif ($parameterClassName === CartRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getCartRepository();
                } elseif ($parameterClassName === CartPriceRuleRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getCartPriceRuleRepository();
                } elseif ($parameterClassName === CartPriceRuleItemRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getCartPriceRuleItemRepository();
                } elseif ($parameterClassName === CartPriceRuleDiscountRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getCartPriceRuleDiscountRepository();
                } elseif ($parameterClassName === CatalogPromotionRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getCatalogPromotionRepository();
                } elseif ($parameterClassName === ConfigurationRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getConfigurationRepository();
                } elseif ($parameterClassName === CouponRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getCouponRepository();
                } elseif ($parameterClassName === ImageRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getImageRepository();
                } elseif ($parameterClassName === OptionRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOptionRepository();
                } elseif ($parameterClassName === OptionProductRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOptionProductRepository();
                } elseif ($parameterClassName === OptionValueRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOptionValueRepository();
                } elseif ($parameterClassName === OrderRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOrderRepository();
                } elseif ($parameterClassName === OrderItemRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getOrderItemRepository();
                } elseif ($parameterClassName === ProductRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getProductRepository();
                } elseif ($parameterClassName === ProductQuantityDiscountRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getProductQuantityDiscountRepository();
                } elseif ($parameterClassName === ProductAttributeRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getProductAttributeRepository();
                } elseif ($parameterClassName === ShipmentTrackerRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getShipmentTrackerRepository();
                } elseif ($parameterClassName === TagRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getTagRepository();
                } elseif ($parameterClassName === TextOptionRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getTextOptionRepository();
                } elseif ($parameterClassName === TaxRateRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getTaxRateRepository();
                } elseif ($parameterClassName === UserRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getUserRepository();
                } elseif ($parameterClassName === UserTokenRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getUserTokenRepository();
                } elseif ($parameterClassName === WarehouseRepositoryInterface::class) {
                    $constructorParameters[] = $this->repositoryFactory->getWarehouseRepository();
                } elseif ($parameterClassName === AttachmentServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getAttachmentService();
                } elseif ($parameterClassName === CartCalculatorInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCartCalculator();
                } elseif ($parameterClassName === CartServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getCart();
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
                } elseif ($parameterClassName === OrderServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getOrder();
                } elseif ($parameterClassName === ShipmentGatewayInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getShipmentGateway();
                } elseif ($parameterClassName === UserServiceInterface::class) {
                    $constructorParameters[] = $this->serviceFactory->getUser();
                } elseif ($parameterClassName === PricingInterface::class || $parameterClassName === Pricing::class) {
                    $constructorParameters[] = $this->pricing;
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
