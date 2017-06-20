<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Uuid;

final class CreateWarehouseCommand extends AbstractWarehouseCommand
{
    public function __construct(
        string $name,
        string $attention,
        string $company,
        string $address1,
        string $address2,
        string $city,
        string $state,
        string $zip5,
        string $zip4,
        string $latitude,
        string $longitude
    ) {
        return parent::__construct(
            $name,
            $attention,
            $company,
            $address1,
            $address2,
            $city,
            $state,
            $zip5,
            $zip4,
            $latitude,
            $longitude,
            Uuid::uuid4()
        );
    }
}
