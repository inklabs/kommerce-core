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
     * @param string $warehouseId
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
        $longitude,
        $warehouseId
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

    public function getWarehouseId()
    {
        return $this->warehouseId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAttention()
    {
        return $this->attention;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getAddress1()
    {
        return $this->address1;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    public function getZip4()
    {
        return $this->zip4;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
}
