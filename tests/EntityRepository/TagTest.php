<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper as Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /**
     * @return Tag
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Tag');
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

        $tag = $this->getRepository()
            ->find(1);

        $tag->getImages()->toArray();
        $tag->getProducts()->toArray();
        $tag->getOptions()->toArray();

        $this->assertTrue($tag instanceof Entity\Tag);
        $this->assertSame(4, $this->countSQLLogger->getTotalQueries());
    }

    public function testGetAllTags()
    {
        $this->setupTag();

        $tags = $this->getRepository()
            ->getAllTags('Test');

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }

    public function testGetTagsByIds()
    {
        $this->setupTag();

        $tags = $this->getRepository()
            ->getTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }

    public function testGetAllTagsByIds()
    {
        $this->setupTag();

        $tags = $this->getRepository()
            ->getAllTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertTrue($tags[0] instanceof Entity\Tag);
    }
}
