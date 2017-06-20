<?php
namespace inklabs\kommerce\Action\Warehouse;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

abstract class AbstractWarehouseCommand implements CommandInterface
{
    /** @var UuidInterface */
    protected $warehouseId;

    /** @var string */
    private $name;

    /** @var string */
    private $attention;

    /** @var string */
    private $company;

    /** @var string */
    private $address1;

    /** @var string */
    private $address2;

    /** @var string */
    private $city;

    /** @var string */
    private $state;

    /** @var string */
    private $zip5;

    /** @var string */
    private $zip4;

    /** @var string */
    private $latitude;

    /** @var string */
    private $longitude;

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
        string $longitude,
        string $warehouseId
    ) {
        $this->warehouseId = Uuid::fromString($warehouseId);
        $this->name = $name;
        $this->attention = $attention;
        $this->company = $company;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->zip5 = $zip5;
        $this->zip4 = $zip4;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getWarehouseId(): UuidInterface
    {
        return $this->warehouseId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAttention(): string
    {
        return $this->attention;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function getAddress2(): string
    {
        return $this->address2;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZip5(): string
    {
        return $this->zip5;
    }

    public function getZip4(): string
    {
        return $this->zip4;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}
