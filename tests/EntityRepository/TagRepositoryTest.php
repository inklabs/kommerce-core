<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class TagRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Tag::class,
        Product::class,
        Option::class,
        TextOption::class,
    ];

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    public function setUp()
    {
        parent::setUp();
        $this->tagRepository = $this->getRepositoryFactory()->getTagRepository();
    }

    private function setupTag()
    {
        $tag = $this->dummyData->getTag();

        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $tag;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->tagRepository,
            $this->dummyData->getTag()
        );
    }

    public function testUpdateFailsWhenNotManaged()
    {
        $tag = $this->dummyData->getTag();

        $this->setExpectedException(
            EntityNotFoundException::class,
            'Tag not found'
        );

        $this->tagRepository->update($tag);
    }

    public function testFindOneById()
    {
        $originalTag = $this->setupTag();
        $this->setCountLogger();

        $tag = $this->tagRepository->findOneById(
            $originalTag->getId()
        );

        $this->visitElements($tag->getImages());
        $this->visitElements($tag->getProducts());
        $this->visitElements($tag->getOptions());
        $this->visitElements($tag->getTextOptions());

        $this->assertEqualEntities($originalTag, $tag);
        $this->assertSame(5, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Tag not found'
        );

        $this->tagRepository->findOneById(
            $this->dummyData->getId()
        );
    }

    public function testFindOneByCode()
    {
        $originalTag = $this->setupTag();
        $tag = $this->tagRepository->findOneByCode($originalTag->getCode());
        $this->assertEqualEntities($originalTag, $tag);
    }

    public function testFindOneByCodeThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Tag not found'
        );

        $this->tagRepository->findOneByCode('xx');
    }

    public function testGetAllTags()
    {
        $originalTag = $this->setupTag();
        $this->setCountLogger();

        $tags = $this->tagRepository->getAllTags('Test');

        $this->visitElements($tags[0]->getImages());
        $this->visitElements($tags[0]->getProducts());
        $this->visitElements($tags[0]->getOptions());
        $this->visitElements($tags[0]->getTextOptions());

        $this->assertEqualEntities($originalTag, $tags[0]);
        $this->assertSame(5, $this->getTotalQueries());
    }

    public function testGetAllTagsSearchByCode()
    {
        $originalTag = $this->setupTag();
        $tag = $this->tagRepository->getAllTags('TT');
        $this->assertEqualEntities($originalTag, $tag[0]);
    }

    public function testGetTagsByIds()
    {
        $originalTag = $this->setupTag();

        $tags = $this->tagRepository->getTagsByIds([
            $originalTag->getId()
        ]);

        $this->assertSame(1, count($tags));
        $this->assertEqualEntities($originalTag, $tags[0]);
    }

    public function testGetAllTagsByIds()
    {
        $originalTag = $this->setupTag();

        $tags = $this->tagRepository->getAllTagsByIds([
            $originalTag->getId()
        ]);

        $this->assertSame(1, count($tags));
        $this->assertEqualEntities($originalTag, $tags[0]);
    }
}
