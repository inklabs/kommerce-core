<?php
namespace inklabs\kommerce\tests\Helper\TestCase;

use inklabs\kommerce\Entity\EntityInterface;
use inklabs\kommerce\Entity\IdEntityInterface;
use inklabs\kommerce\Entity\ValidationInterface;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactory;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\PricingInterface;
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
use inklabs\kommerce\Lib\Pricing;
use Symfony\Component\Validator\Validation;

abstract class KommerceTestCase extends \PHPUnit_Framework_TestCase
{
    const UUID_HEX = '15dc6044910c431aa578430759ef5dcf';
    const SESSION_ID = '6is7ujb3crb5ja85gf91g9en62';
    const EMAIL = 'john.doe@example.com';
    const IP4 = '127.0.0.1';
    const ZIP5 = '76667';
    const STATE = 'TX';
    const SHIPMENT_EXTERNAL_ID = 'shp_xxxxx';
    const SHIPMENT_RATE_EXTERNAL_ID = 'shp_xxxxxxxx';
    const SHIPMENT_TRACKING_CODE = 'XXXXXXX';
    const RATE_EXTERNAL_ID = 'rate_xxxxxxxxx';
    const USER_AGENT = 'UserAgent String';
    const COUPON_CODE = 'coupon123';
    const CURRENCY = 'USD';
    const USERS_CSV_FILENAME = __DIR__ . '/../../_files/CSVIterator/users.csv';
    const ORDERS_CSV_FILENAME = __DIR__ . '/../../_files/CSVIterator/orders.csv';
    const FLOAT_TAX_RATE = 9.5;
    const FAKE_TIMESTAMP = 1482913105;
    const FAKE_TEXT = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididun';
    const FAKE_SKU = 'ZK03B7';

    /** @var DummyData */
    protected $dummyData;

    public function setUp()
    {
        $this->dummyData = new DummyData;
    }

    protected function getCartCalculator()
    {
        $cartCalculator = new CartCalculator(new Pricing);
        return $cartCalculator;
    }

    /**
     * @return DTOBuilderFactoryInterface
     */
    protected function getDTOBuilderFactory()
    {
        return new DTOBuilderFactory();
    }

    /**
     * @return Pricing
     */
    protected function getPricing()
    {
        return new Pricing();
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

    protected function assertEntityValid(ValidationInterface $entity)
    {
        $errors = $this->getValidationErrors($entity);

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
     * @param int $expected
     * @param int $actual
     * @param int $delta
     */
    protected function assertCloseTo($expected, $actual, $delta = 5)
    {
        $difference = abs($expected - $actual);
        $this->assertTrue($difference >= 0 && $difference <= $delta);
    }

    protected function assertEntitiesEqual(IdEntityInterface $entity1, IdEntityInterface $entity2)
    {
        if (! $entity1->getId()->equals($entity2->getId())) {
            $this->fail(
                'Failed asserting entities ARE equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId()->getHex() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()->getHex()
            );
        }
    }

    protected function assertEntitiesNotEqual(IdEntityInterface $entity1, IdEntityInterface $entity2)
    {
        if ($entity1->getId()->equals($entity2->getId())) {
            $this->fail(
                'Failed asserting entities NOT equal:' . PHP_EOL .
                get_class($entity1) . ': ' . $entity1->getId()->getHex() . PHP_EOL .
                get_class($entity2) . ': ' . $entity2->getId()->getHex()
            );
        }
    }

    /**
     * @param IdEntityInterface $expectedEntity
     * @param IdEntityInterface[] $entities
     */
    protected function assertEntityInArray(IdEntityInterface $expectedEntity, array $entities)
    {
        $this->assertTrue($this->isEntityInArray($expectedEntity, $entities));
    }

    /**
     * @param IdEntityInterface $expectedEntity
     * @param IdEntityInterface[] $entities
     * @return bool
     */
    protected function isEntityInArray(IdEntityInterface $expectedEntity, array $entities)
    {
        foreach ($entities as $entity) {
            if ($expectedEntity->getId()->equals($entity->getId())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $exceptionClassName
     * @param string|null $message
     * @param int|string|null $code
     */
    public function setExpectedException($exceptionClassName, $message = null, $code = null)
    {
        $this->expectException($exceptionClassName);

        if ($message !== null) {
            $this->expectExceptionMessage($message);
        }

        if ($code !== null) {
            $this->expectExceptionCode($code);
        }
    }
}
