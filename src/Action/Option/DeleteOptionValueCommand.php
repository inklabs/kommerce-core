<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteOptionValueCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionValueId;

    /**
     * @param string $optionValueId
     */
    public function __construct($optionValueId)
    {
        $this->optionValueId = Uuid::fromString($optionValueId);
    }

    public function getOptionValueId()
    {
        return $this->optionValueId;
    }
}
