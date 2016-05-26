<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use Ramsey\Uuid\UuidInterface;

interface AttachmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $uuid4
     * @return Attachment
     */
    public function findOneByUuid(UuidInterface $uuid4);
}
