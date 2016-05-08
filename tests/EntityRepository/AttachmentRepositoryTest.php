<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;
use Ramsey\Uuid\Uuid;

class AttachmentRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
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

    public function testFindOneById()
    {
        $expectedAttachment = $this->setupAttachment();

        $this->setCountLogger();

        $attachment = $this->attachmentRepository->findOneByUuid($expectedAttachment->getId());

        $this->assertSame($expectedAttachment->getId()->toString(), $attachment->getId()->toString());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Attachment not found'
        );

        $this->attachmentRepository->findOneByUuid(Uuid::uuid4());
    }
}
