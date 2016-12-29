<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\UserProductAttachment;
use inklabs\kommerce\EntityDTO\UploadFileDTO;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\UuidInterface;

class AttachmentService implements AttachmentServiceInterface
{
    use EntityValidationTrait;

    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    /** @var FileManagerInterface */
    private $fileManager;

    /** @var OrderServiceInterface */
    private $orderService;

    /** @var ProductServiceInterface */
    private $productService;

    /** @var UserServiceInterface */
    private $userService;

    public function __construct(
        AttachmentRepositoryInterface $attachmentRepository,
        FileManagerInterface $fileManager,
        OrderServiceInterface $orderService,
        ProductServiceInterface $productService,
        UserServiceInterface $userService
    ) {
        $this->attachmentRepository = $attachmentRepository;
        $this->fileManager = $fileManager;
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->userService = $userService;
    }

    public function create(Attachment & $attachment)
    {
        $this->attachmentRepository->create($attachment);
    }

    public function update(Attachment & $attachment)
    {
        $this->attachmentRepository->update($attachment);
    }

    public function delete(Attachment $attachment)
    {
        $this->attachmentRepository->delete($attachment);
    }

    /**
     * @param UuidInterface $attachmentId
     * @return Attachment
     * @throws EntityNotFoundException
     */
    public function getOneById(UuidInterface $attachmentId)
    {
        return $this->attachmentRepository->findOneById($attachmentId);
    }

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param UuidInterface $orderItemId
     * @return void
     */
    public function createAttachmentForOrderItem(UploadFileDTO $uploadFileDTO, UuidInterface $orderItemId)
    {
        $orderItem = $this->orderService->getOrderItemById($orderItemId);
        $order = $orderItem->getOrder();

        $attachment = $this->createAttachment($uploadFileDTO);

        $orderItem->addAttachment($attachment);
        $this->orderService->update($order);
    }

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @param UuidInterface $userId
     * @param UuidInterface $productId
     * @return void
     */
    public function createAttachmentForUserProduct(
        UploadFileDTO $uploadFileDTO,
        UuidInterface $userId,
        UuidInterface $productId
    ) {
        $user = $this->userService->findOneById($userId);
        $product = $this->productService->findOneById($productId);

        $attachment = $this->createAttachment($uploadFileDTO);

        $userProductAttachment = new UserProductAttachment($user, $product, $attachment);
        $this->attachmentRepository->create($userProductAttachment);
    }

    /**
     * @param UploadFileDTO $uploadFileDTO
     * @return Attachment
     */
    private function createAttachment(UploadFileDTO $uploadFileDTO)
    {
        $managedFile = $this->fileManager->saveFile($uploadFileDTO->getFilePath());

        $attachment = new Attachment(
            $managedFile->getUri()
        );

        $this->attachmentRepository->create($attachment);

        return $attachment;
    }
}
