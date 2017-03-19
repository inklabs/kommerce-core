<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Uuid;

final class CreateWarehouseCommand extends AbstractWarehouseCommand
{
    /**
     * @param string $name
     * @param string $attention
     * @param string $company
     * @param string $address1
     * @param string $address2
     * @param string $city
     * @param string $state
     * @param string $zip5
     * @param string $zip4
     * @param string $latitude
     * @param string $longitude
     */
    public function __construct(
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
        $longitude
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
