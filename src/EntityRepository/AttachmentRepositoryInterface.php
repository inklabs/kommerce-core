<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Lib\UuidInterface;

/**
 * @method Attachment findOneById(UuidInterface $id)
 */
interface AttachmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UuidInterface $userId
     * @param UuidInterface $productId
     * @return Attachment[]
     */
    public function getUserProductAttachments(UuidInterface $userId, UuidInterface $productId);
}
