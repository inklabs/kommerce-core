<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Uuid;

final class CreateAttributeCommand extends AbstractAttributeCommand
{
    /**
     * @param string $name
     * @param string $choiceTypeSlug
     * @param int $sortOrder
     * @param null|string $description
     */
    public function __construct(
        $name,
        $choiceTypeSlug,
        $sortOrder,
        $description
    ) {
        return parent::__construct(
            $name,
            $choiceTypeSlug,
            $sortOrder,
            $description,
            Uuid::uuid4()
        );
    }
}
