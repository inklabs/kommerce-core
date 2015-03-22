<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\tests\Helper as Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /* @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Tag */
    protected $mockTagRepository;

    /* @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    public function setUp()
    {
        $this->mockTagRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Tag');
        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
    }

    private function setupTag()
    {
        $tag = $this->getDummyTag();

        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);

        $product1->addTag($tag);
        $product2->addTag($tag);
        $product3->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();

        return $tag;
    }

    public function testFind()
    {
        $tag = $this->getDummyTag();

        $this->mockTagRepository
            ->shouldReceive('find')
            ->andReturn($tag);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tag = $tagService->find(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindReturnsNull()
    {
        $this->mockTagRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tag = $tagService->find(1);
        $this->assertSame(null, $tag);
    }

    public function testFindSimple()
    {
        $tag = $this->getDummyTag();

        $this->mockTagRepository
            ->shouldReceive('find')
            ->andReturn($tag);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tag = $tagService->findSimple(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindSimpleReturnsNull()
    {
        $this->mockTagRepository
            ->shouldReceive('find')
            ->andReturn(null);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tag = $tagService->findSimple(1);
        $this->assertSame(null, $tag);
    }

    public function testEdit()
    {
        $tagValues = $this->setupTag()->getView()->export();
        $tagValues->name = 'Test Tag 2';

        $tagService = new Tag($this->entityManager, new Pricing);
        $tag = $tagService->edit($tagValues->id, $tagValues);
        $this->assertTrue($tag instanceof Entity\Tag);

        $this->entityManager->clear();

        $tag = $this->entityManager->find('kommerce:Tag', 1);
        $this->assertSame('Test Tag 2', $tag->getName());
        $this->assertNotSame($tagValues->updated, $tag->getUpdated());
    }

    /**
     * @expectedException \LogicException
     */
    public function testEditWithMissingTag()
    {
        $tagService = new Tag($this->entityManager, new Pricing);
        $tagService->edit(1, new View\Tag(new Entity\Tag));
    }

    public function testCreate()
    {
        $tagValues = $this->setupTag()->getView()->export();

        $tagService = new Tag($this->entityManager, new Pricing);
        $tag = $tagService->create($tagValues);
        $this->assertTrue($tag instanceof Entity\Tag);

        $this->entityManager->clear();

        $tag = $this->entityManager->find('kommerce:Tag', 1);
        $this->assertTrue($tag instanceof Entity\Tag);
    }

    public function testGetAllTags()
    {
        $this->mockTagRepository
            ->shouldReceive('getAllTags')
            ->andReturn([new Entity\Tag]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tags = $tagService->getAllTags();
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testGetTagsByIds()
    {
        $this->mockTagRepository
            ->shouldReceive('getTagsByIds')
            ->andReturn([new Entity\Tag]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tags = $tagService->getTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testAllGetTagsByIds()
    {
        $this->mockTagRepository
            ->shouldReceive('getAllTagsByIds')
            ->andReturn([new Entity\Tag]);

        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->andReturn($this->mockTagRepository);

        $tagService = new Tag($this->mockEntityManager, new Pricing);

        $tags = $tagService->getAllTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }
}
