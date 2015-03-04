<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib\BaseConvert;
use inklabs\kommerce\tests\Helper as Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Tag */
    protected $tag;

    /**
     * @return Tag
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Tag');
    }

    /**
     * @return Entity\Tag
     */
    private function getDummyTag($num)
    {
        $tag = new Entity\Tag;
        $tag->setName('Test Tag ' . $num);
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsActive(true);
        $tag->setIsVisible(true);
        return $tag;
    }

    private function setupTag()
    {
        $tag1 = $this->getDummyTag(1);

        $this->entityManager->persist($tag1);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupTag();

        $tag = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $tag->getId());
    }

    public function testGetAllTags()
    {
        $this->setupTag();

        $tags = $this->getRepository()
            ->getAllTags('Test');

        $this->assertSame(1, $tags[0]->getId());
    }

    public function testGetTagsByIds()
    {
        $this->setupTag();

        $tags = $this->getRepository()
            ->getTagsByIds([1]);

        $this->assertSame(1, count($tags));
        $this->assertSame(1, $tags[0]->getId());
    }

    public function testGetAllTagsByIds()
    {
        $this->setupTag();

        $tags = $this->getRepository()
            ->getAllTagsByIds([1]);

        $this->assertSame(1, $tags[0]->getId());
    }
}
