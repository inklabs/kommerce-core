<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use Ramsey\Uuid\UuidInterface;

class AttachmentRepository extends AbstractRepository implements AttachmentRepositoryInterface
{
    /**
     * @param UuidInterface $uuid4
     * @return Attachment
     */
    public function findOneByUuid(UuidInterface $uuid4)
    {
        return $this->returnOrThrowNotFoundException(
            parent::findOneBy(['id' => $uuid4])
        );
    }
}
