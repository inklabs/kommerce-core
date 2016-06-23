<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteOptionProductCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionProductId;

    /**
     * @param string $optionProductId
     */
    public function __construct($optionProductId)
    {
        $this->optionProductId = Uuid::fromString($optionProductId);
    }

    public function getOptionProductId()
    {
        return $this->optionProductId;
    }
}
