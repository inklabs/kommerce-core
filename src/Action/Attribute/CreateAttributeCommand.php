<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Uuid;

final class CreateAttributeCommand extends AbstractAttributeCommand
{
    /**
     * @param string $name
     * @param int $sortOrder
     * @param null|string $description
     */
    public function __construct(
        $name,
        $sortOrder,
        $description
    ) {
        return parent::__construct(
            $name,
            $sortOrder,
            $description,
            Uuid::uuid4()
        );
    }
}
