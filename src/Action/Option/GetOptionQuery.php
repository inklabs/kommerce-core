<?php
namespace inklabs\kommerce\Action\Option;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOptionQuery implements QueryInterface
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
