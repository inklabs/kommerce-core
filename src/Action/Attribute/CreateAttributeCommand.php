<?php
namespace inklabs\kommerce\Action\Attribute;

use inklabs\kommerce\Lib\Uuid;

final class CreateAttributeCommand extends AbstractAttributeCommand
{
    public function __construct(
        string $name,
        string $choiceTypeSlug,
        int $sortOrder,
        ?string $description
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
