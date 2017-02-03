<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class AttachmentRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        OrderItem::class,
    ];

    /** @var AttachmentRepositoryInterface */
    protected $attachmentRepository;

    public function setUp()
    {
        parent::setUp();
        $this->attachmentRepository = $this->getRepositoryFactory()->getAttachmentRepository();
    }

    private function setupAttachment()
    {
        $attachment = $this->dummyData->getAttachment();

        $this->entityManager->persist($attachment);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $attachment;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->attachmentRepository,
            $this->dummyData->getAttachment()
        );
    }

    public function testFindOneById()
    {
        $originalAttachment = $this->setupAttachment();
        $this->setCountLogger();

        $attachment = $this->attachmentRepository->findOneById($originalAttachment->getId());

        $this->assertEquals($originalAttachment->getId(), $attachment->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Attachment not found'
        );

        $this->attachmentRepository->findOneById($this->dummyData->getId());
    }
}
