<?php
namespace inklabs\kommerce\Lib\PaymentGateway;

use inklabs\kommerce\Entity\View as View;

class ChargeResponse
{
    protected $id;
    protected $created;
    protected $amount;
    protected $last4;
    protected $currency;
    protected $fee;
    protected $description;

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = (int) $amount;
    }

    public function getLast4()
    {
        return $this->last4;
    }

    public function setLast4($last4)
    {
        $this->last4 = (string) $last4;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = (int) $created;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = (string) $currency;
    }

    public function getFee()
    {
        return $this->fee;
    }

    public function setFee($fee)
    {
        $this->fee = (int) $fee;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (string) $id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = (string) $description;
    }

    /**
     * @return View\ChargeResponse
     */
    public function getView()
    {
        return new View\ChargeResponse($this);
    }
}
