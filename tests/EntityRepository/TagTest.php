<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper;

class TagTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Image',
        'kommerce:Tag',
        'kommerce:Product',
        'kommerce:Option',
        'kommerce:TextOption',
    ];

    /** @var TagInterface */
    protected $tagRepository;

    public function setUp()
    {
        $this->tagRepository = $this->entityManager->getRepository('kommerce:Tag');
    }

    private function setupTag()
    {
        $tag = $this->getDummyTag();

        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        $this->entityManager->clear();
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
