<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;
use Ramsey\Uuid\UuidInterface;

class AttachmentDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $attachment = $this->dummyData->getAttachment();

        $product = $this->dummyData->getProduct();
        $product->enableAttachments();

        $orderItem = $this->dummyData->getOrderItem($product);
        $orderItem->addAttachment($attachment);

        $attachmentDTO = $attachment->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($attachmentDTO instanceof AttachmentDTO);
        $this->assertTrue($attachmentDTO->id instanceof UuidInterface);
        $this->assertTrue($attachmentDTO->orderItems[0] instanceof OrderItemDTO);
    }
}
