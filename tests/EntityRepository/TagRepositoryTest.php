<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
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
        $tag = $this->dummyData->getTag();

        $this->tagRepository->create($tag);
        $this->assertSame(1, $tag->getId());

        $tag->setName('New Name');
        $this->assertSame(null, $tag->getUpdated());

        $this->tagRepository->update($tag);
        $this->assertTrue($tag->getUpdated() instanceof DateTime);

        $this->tagRepository->delete($tag);
        $this->assertSame(null, $tag->getId());
    }

    public function testFindOneById()
    {
        $this->setupTag();

        $this->setCountLogger();

        $tag = $this->tagRepository->findOneById(1);

        $tag->getImages()->toArray();
        $tag->getProducts()->toArray();
        $tag->getOptions()->toArray();
        $tag->getTextOptions()->toArray();

        $this->assertTrue($tag instanceof Tag);
        $this->assertSame(5, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Tag not found'
        );

        $this->tagRepository->findOneById(1);
    }

    public function testFindOneByCode()
    {
        $this->setupTag();
        $tag = $this->tagRepository->findOneByCode('TT1');
        $this->assertTrue($tag instanceof Tag);
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
        $this->setupTag();

        $this->setCountLogger();

        $tags = $this->tagRepository->getAllTags('Test');

        $tags[0]->getImages()->toArray();
        $tags[0]->getProducts()->toArray();
        $tags[0]->getOptions()->toArray();
        $tags[0]->getTextOptions()->toArray();

        $this->assertTrue($tags[0] instanceof Tag);
        $this->assertSame(5, $this->getTotalQueries());
    }

    public function testGetAllTagsSearchByCode()
    {
        $this->setupTag();
        $tags = $this->tagRepository->getAllTags('TT');
        $this->assertTrue($tags[0] instanceof Tag);
    }

    public function testGetTagsByIds()
    {
        $this->setupTag();

        $tags = $this->tagRepository->getTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Tag);
    }

    public function testGetAllTagsByIds()
    {
        $this->setupTag();

        $tags = $this->tagRepository->getAllTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Tag);
    }
}
