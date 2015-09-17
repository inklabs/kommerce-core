<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper;

class TagRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Image',
        'kommerce:Tag',
        'kommerce:Product',
        'kommerce:Option',
        'kommerce:TextOption',
    ];

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    public function setUp()
    {
        $this->tagRepository = $this->repository()->getTagRepository();
    }

    private function setupTag()
    {
        $tag = $this->getDummyTag();

        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $tag;
    }

    public function testCRUD()
    {
        $tag = $this->getDummyTag();

        $this->tagRepository->create($tag);
        $this->assertSame(1, $tag->getId());

        $tag->setName('New Name');
        $this->assertSame(null, $tag->getUpdated());

        $this->tagRepository->save($tag);
        $this->assertTrue($tag->getUpdated() instanceof \DateTime);

        $this->tagRepository->remove($tag);
        $this->assertSame(null, $tag->getId());
    }

    public function testFind()
    {
        $this->setupTag();

        $this->setCountLogger();

        $tag = $this->tagRepository->find(1);

        $tag->getImages()->toArray();
        $tag->getProducts()->toArray();
        $tag->getOptions()->toArray();
        $tag->getTextOptions()->toArray();

        $this->assertTrue($tag instanceof Entity\Tag);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }

    public function testFindOneBy()
    {
        $this->setupTag();

        $tag = $this->tagRepository->findOneBy([
            'code' => 'TT1',
        ]);

        $this->assertTrue($tag instanceof Entity\Tag);
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

        $this->assertTrue($tags[0] instanceof Entity\Tag);
        $this->assertSame(5, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetTagsByIds()
    {
        $this->setupTag();

        $tags = $this->tagRepository->getTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }

    public function testGetAllTagsByIds()
    {
        $this->setupTag();

        $tags = $this->tagRepository->getAllTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }
}
