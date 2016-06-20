<?php
namespace inklabs\kommerce\Action\Option\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetOptionRequest
{
    /** @var UuidInterface */
    private $optionId;

    /**
     * @param string $optionId
     */
    public function __construct($optionId)
    {
        $this->optionId = Uuid::fromString($optionId);
    }

    public function getOptionId()
    {
        return $this->optionId;
    }
}
