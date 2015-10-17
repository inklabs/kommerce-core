<?php
namespace inklabs\kommerce\tests\Helper;

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
use inklabs\kommerce\tests\Helper\EntityRepository\FakeRepositoryFactory;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Lib\DoctrineHelper;
use Doctrine;

abstract class DoctrineTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var DoctrineHelper */
    protected $kommerce;

    /** @var CountSQLLogger */
    protected $countSQLLogger;

    /** @var string[] */
    protected $metaDataClassNames;

    /** @var DummyData */
    protected $dummyData;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

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
        $this->kommerce = new DoctrineHelper(new Doctrine\Common\Cache\ArrayCache());
        $this->kommerce->addSqliteFunctions();
        $this->kommerce->setup([
            'driver' => 'pdo_sqlite',
            'memory' => true,
        ]);

        $this->entityManager = $this->kommerce->getEntityManager();
    }

    private function setupTestSchema()
    {
        $this->entityManager->clear();

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
        $this->kommerce->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function setCountLogger($enableDisplay = false)
    {
        $this->countSQLLogger = new CountSQLLogger($enableDisplay);
        $this->kommerce->setSqlLogger($this->countSQLLogger);
    }

    public function getTotalQueries()
    {
        return $this->countSQLLogger->getTotalQueries();
    }

    protected function getCommandBus(CartCalculatorInterface $cartCalculator = null)
    {
        return new CommandBus($this->getServiceFactory($cartCalculator));
    }

    protected function getQueryBus(CartCalculatorInterface $cartCalculator = null)
    {
        return new QueryBus($this->getServiceFactory($cartCalculator), new Pricing);
    }

    protected function getEventDispatcher()
    {
        return new EventDispatcher;
    }

    protected function getRepositoryFactory()
    {
        return new RepositoryFactory($this->entityManager);
    }

    protected function getFakeRepositoryFactory()
    {
        return new FakeRepositoryFactory;
    }

    protected function getServiceFactory(
        CartCalculatorInterface $cartCalculator = null,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        if ($cartCalculator === null) {
            $cartCalculator = new CartCalculator(new Pricing);
        }

        if ($eventDispatcher === null) {
            $eventDispatcher = new EventDispatcher;
        }

        return new ServiceFactory(
            $this->getRepositoryFactory(),
            $cartCalculator,
            $eventDispatcher
        );
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
}
