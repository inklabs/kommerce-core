<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class TextOptionRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        TextOption::class,
        Tag::class,
    ];

    /** @var TextOptionRepositoryInterface */
    protected $textOptionRepository;

    public function setUp()
    {
        parent::setUp();
        $this->textOptionRepository = $this->getRepositoryFactory()->getTextOptionRepository();
    }

    private function setupOption()
    {
        $textOption = $this->dummyData->getTextOption();

        $this->entityManager->persist($textOption);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $textOption;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->textOptionRepository,
            $this->dummyData->getTextOption()
        );
    }

    public function testFind()
    {
        $originalTextOption = $this->setupOption();
        $this->setCountLogger();

        $textOption = $this->textOptionRepository->findOneById(
            $originalTextOption->getId()
        );

        $this->visitElements($textOption->getTags());

        $this->assertEntitiesEqual($originalTextOption, $textOption);
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testGetAllOptionsByIds()
    {
        $originalTextOption = $this->setupOption();

        $textOptions = $this->textOptionRepository->getAllTextOptionsByIds([
            $originalTextOption->getId()
        ]);

        $this->assertEntitiesEqual($originalTextOption, $textOptions[0]);
    }
}
