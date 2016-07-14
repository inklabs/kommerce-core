<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Lib\UuidInterface;

interface AttachmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $uuid4
     * @return Attachment
     */
    public function findOneByUuid(UuidInterface $uuid4);

    /**
     * @param UuidInterface $userId
     * @param UuidInterface $productId
     * @return Attachment[]
     */
    public function getUserProductAttachments(UuidInterface $userId, UuidInterface $productId);
}
