<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteOptionCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $optionId;

    public function __construct(string $optionId)
    {
        $this->optionId = Uuid::fromString($optionId);
    }

    public function getOptionId(): UuidInterface
    {
        return $this->optionId;
    }
}
