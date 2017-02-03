<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForUserProductCommand;
use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserProductAttachment;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttachmentForUserProductHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Attachment::class,
        Product::class,
        Tag::class,
        User::class,
        UserProductAttachment::class,
        Cart::class,
    ];

    public function testHandle()
    {
        $user = $this->dummyData->getUser();
        $product = $this->dummyData->getProduct();
        $product->enableAttachments();
        $this->persistEntityAndFlushClear([
            $user,
            $product,
        ]);
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $command = new CreateAttachmentForUserProductCommand(
            $uploadFileDTO,
            $user->getId()->getHex(),
            $product->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $userProductAttachments = $this->getRepositoryFactory()->getAttachmentRepository()->getUserProductAttachments(
            $user->getId(),
            $product->getId()
        );
        $this->assertNotEmpty($userProductAttachments);
    }
}
