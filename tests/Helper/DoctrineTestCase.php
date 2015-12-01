<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Entity\ValidationInterface;
use inklabs\kommerce\Lib\Mapper;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\PaymentGateway\FakePaymentGateway;
use inklabs\kommerce\tests\Helper\Entity\DummyData;
use inklabs\kommerce\EntityDTO\AttributeDTO;
use inklabs\kommerce\EntityDTO\AttributeValueDTO;
use inklabs\kommerce\EntityDTO\CatalogPromotionDTO;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\EntityDTO\OptionDTO;
use inklabs\kommerce\EntityDTO\OptionProductDTO;
use inklabs\kommerce\EntityDTO\PriceDTO;
use inklabs\kommerce\EntityDTO\ProductAttributeDTO;
use inklabs\kommerce\EntityDTO\ProductDTO;
use inklabs\kommerce\EntityDTO\ProductQuantityDiscountDTO;
use inklabs\kommerce\EntityDTO\TextOptionDTO;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\Lib\Command\CommandBus;
use inklabs\kommerce\Lib\Event\EventDispatcher;
use inklabs\kommerce\Lib\Query\QueryBus;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Service\ServiceFactory;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\DoctrineHelper;
use Doctrine;
use Mockery;
use Symfony\Component\Validator\Validation;

abstract class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /** @var CountSQLLogger */
    protected $countSQLLogger;

    /** @var string[] */
    protected $metaDataClassNames;

    /** @var DummyData */
    protected $dummyData;

    public function setUp()
    {
        if ($this->metaDataClassNames !== null) {
            $this->setupEntityManager();
        }

        $this->dummyData = new DummyData;
    }

    protected function setupEntityManager($metaDataClassNames = null)
    {
        if ($metaDataClassNames !== null) {
            $this->metaDataClassNames = $metaDataClassNames;
        }

        $this->getConnection();
        $this->setupTestSchema();
    }

    private function getConnection()
    {
        $this->doctrineHelper = new DoctrineHelper(new Doctrine\Common\Cache\ArrayCache());
        $this->doctrineHelper->setup([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);
        $this->doctrineHelper->addSqliteFunctions();

        $this->entityManager = $this->doctrineHelper->getEntityManager();
    }

    private function setupTestSchema()
    {
        if ($this->metaDataClassNames === null) {
            $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();
        } else {
            $classes = [];
            foreach ($this->metaDataClassNames as $className) {
                $classes[] = $this->entityManager->getMetaDataFactory()->getMetadataFor($className);
            }
        }

        $tool = new Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $tool->createSchema($classes);
    }

    public function setEchoLogger()
    {
        $this->doctrineHelper->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function setCountLogger($enableDisplay = false)
    {
        $this->countSQLLogger = new CountSQLLogger($enableDisplay);
        $this->doctrineHelper->setSqlLogger($this->countSQLLogger);
    }

    public function getTotalQueries()
    {
        return $this->countSQLLogger->getTotalQueries();
    }

    protected function getMapper(ServiceFactory $serviceFactory = null, Pricing $pricing = null)
    {
        if ($serviceFactory === null) {
            $serviceFactory = $this->getServiceFactory();
        }

        if ($pricing === null) {
            $pricing = new Pricing;
        }

        return new Mapper($serviceFactory, $pricing);
    }

    protected function getCommandBus()
    {
        return new CommandBus($this->getMapper());
    }

    protected function getQueryBus()
    {
        return new QueryBus($this->getMapper());
    }

    protected function getEventDispatcher()
    {
        return new EventDispatcher;
    }

    protected function getRepositoryFactory()
    {
        return new RepositoryFactory($this->entityManager);
    }

    protected function getServiceFactory(
        CartCalculatorInterface $cartCalculator = null,
        EventDispatcherInterface $eventDispatcher = null,
        PaymentGatewayInterface $paymentGateway = null
    ) {
        if ($cartCalculator === null) {
            $cartCalculator = $this->getCartCalculator();
        }

        if ($eventDispatcher === null) {
            $eventDispatcher = new EventDispatcher;
        }

        if ($paymentGateway === null) {
            $paymentGateway = $this->getPaymentGateway();
        }

        return new ServiceFactory(
            $this->getRepositoryFactory(),
            $cartCalculator,
            $eventDispatcher,
            $paymentGateway
        );
    }

    protected function getPaymentGateway()
    {
        return new FakePaymentGateway;
    }

    protected function getCartCalculator()
    {
        $cartCalculator = new CartCalculator(new Pricing);
        return $cartCalculator;
    }

    protected function beginTransaction()
    {
        $this->entityManager->getConnection()->beginTransaction();
    }

    protected function rollback()
    {
        $this->entityManager->getConnection()->rollback();
    }

    protected function assertFullProductDTO(ProductDTO $productDTO)
    {
        $this->assertTrue($productDTO instanceof ProductDTO);
        $this->assertTrue($productDTO->tags[0]->images[0] instanceof ImageDTO);
        $this->assertTrue($productDTO->tags[0]->options[0] instanceof OptionDTO);
        $this->assertTrue($productDTO->tags[0]->textOptions[0] instanceof TextOptionDTO);
        $this->assertTrue($productDTO->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($productDTO->productQuantityDiscounts[0]->price instanceof PriceDTO);
        $this->assertTrue($productDTO->price instanceof PriceDTO);
        $this->assertTrue($productDTO->price->catalogPromotions[0] instanceof CatalogPromotionDTO);
        $this->assertTrue($productDTO->price->productQuantityDiscounts[0] instanceof ProductQuantityDiscountDTO);
        $this->assertTrue($productDTO->images[0] instanceof ImageDTO);
        $this->assertTrue($productDTO->tagImages[0] instanceof ImageDTO);
        $this->assertTrue($productDTO->productAttributes[0] instanceof ProductAttributeDTO);
        $this->assertTrue($productDTO->productAttributes[0]->attribute instanceof AttributeDTO);
        $this->assertTrue($productDTO->productAttributes[0]->attributeValue instanceof AttributeValueDTO);
        $this->assertTrue($productDTO->optionProducts[0] instanceof OptionProductDTO);
        $this->assertTrue($productDTO->optionProducts[0]->option instanceof OptionDTO);
    }

    protected function assertTypeInArray($className, $array)
    {
        $this->assertTrue($this->isTypeInArray($className, $array));
    }

    protected function assertTypeNotInArray($className, $array)
    {
        $this->assertFalse($this->isTypeInArray($className, $array));
    }

    protected function isTypeInArray($className, $array)
    {
        foreach ($array as $item) {
            if ($className === get_class($item)) {
                return true;
            }
        }

        return false;
    }

    protected function assertEntityValid($shipmentTracking)
    {
        $errors = $this->getValidationErrors($shipmentTracking);

        $messages = [];
        foreach ($errors as $violation) {
            $messages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
        }
        $errorMessage = implode(PHP_EOL, $messages);

        $this->assertEmpty($errors, $errorMessage);
    }

    /**
     * @param validationInterface $entity
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected function getValidationErrors(ValidationInterface $entity)
    {
        return Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator()
            ->validate($entity);
    }

    /**
     * @param string $className
     * @return Mockery\Mock
     */
    protected function getMockeryMock($className)
    {
        return Mockery::mock($className);
    }
}
