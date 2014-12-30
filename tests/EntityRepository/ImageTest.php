<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class ImageTest extends Helper\DoctrineTestCase
{
    /**
     * @return Image
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Image');
    }

    public function setUp()
    {
        $image = new Entity\Image;
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(0);

        $this->entityManager->persist($image);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\Image $image */
        $image = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $image->getId());
    }
}
