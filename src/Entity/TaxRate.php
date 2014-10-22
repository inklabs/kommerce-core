<?php
namespace inklabs\kommerce\Entity;

class TaxRate
{
    use Accessor\Time;

    protected $id;
    protected $state;
    protected $zip5;
    protected $zip5From;
    protected $zip5To;
    protected $rate;
    protected $applyToShipping;

    public function __construct()
    {
        $this->setCreated();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setZip5($zip5)
    {
        $this->zip5 = $zip5;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    public function setZip5From($zip5From)
    {
        $this->zip5From = $zip5From;
    }

    public function getZip5From()
    {
        return $this->zip5From;
    }

    public function setZip5To($zip5To)
    {
        $this->zip5To = $zip5To;
    }

    public function getZip5To()
    {
        return $this->zip5To;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setApplyToShipping($applyToShipping)
    {
        $this->applyToShipping = $applyToShipping;
    }

    public function getApplyToShipping()
    {
        return $this->applyToShipping;
    }

    public function getTax($tax_subtotal, $shipping)
    {
        if ($this->applyToShipping) {
            $tax_subtotal += $shipping;
        }

        return (int) round($tax_subtotal * ($this->rate / 100));
    }
}
