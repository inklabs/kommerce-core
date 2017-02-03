<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\UserProductAttachment;
use inklabs\kommerce\Lib\UuidInterface;

class AttachmentRepository extends AbstractRepository implements AttachmentRepositoryInterface
{
    /**
     * @param UuidInterface $userId
     * @param UuidInterface $productId
     * @return Attachment[]
     */
    public function getUserProductAttachments(UuidInterface $userId, UuidInterface $productId)
    {
        $attachments = $this->getQueryBuilder()
            ->select('Attachment')
            ->from(Attachment::class, 'Attachment')
            ->innerJoin(UserProductAttachment::class, 'UserProductAttachment')
            ->andWhere('UserProductAttachment.user = :userId')
            ->andWhere('UserProductAttachment.product = :productId')
            ->setIdParameter('userId', $userId)
            ->setIdParameter('productId', $productId)
            ->getQuery()
            ->getResult();

        return $attachments;
    }
}
