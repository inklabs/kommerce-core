<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteOptionProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionProductId;

    public function __construct(string $optionProductId)
    {
        $this->optionProductId = Uuid::fromString($optionProductId);
    }

    public function getOptionProductId(): UuidInterface
    {
        return $this->optionProductId;
    }
}
