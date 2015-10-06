<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\TaxRateDTOBuilder;
use inklabs\kommerce\View;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class TaxRate implements ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $state;

    /** @var string */
    protected $zip5;

    /** @var string */
    protected $zip5From;

    /** @var string */
    protected $zip5To;

    /** @var double */
    protected $rate;

    /** @var bool */
    protected $applyToShipping;

    public function __construct()
    {
        $this->setCreated();

        $this->applyToShipping = false;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('state', new Assert\Length([
            'min' => 2,
            'max' => 2,
        ]));

        $zipRegex = [
            'pattern' => '/[0-9]{5}/',
            'match'   => true,
            'message' => 'Must be a valid 5 digit postal code',
        ];

        $metadata->addPropertyConstraint('zip5', new Assert\Regex($zipRegex));
        $metadata->addPropertyConstraint('zip5From', new Assert\Regex($zipRegex));
        $metadata->addPropertyConstraint('zip5To', new Assert\Regex($zipRegex));

        $metadata->addPropertyConstraint('rate', new Assert\NotBlank);
        $metadata->addPropertyConstraint('rate', new Assert\Range([
            'min' => 0,
            'max' => 100,
        ]));
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
        $this->rate = (double) $rate;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setApplyToShipping($applyToShipping)
    {
        $this->applyToShipping = (bool) $applyToShipping;
    }

    public function getApplyToShipping()
    {
        return $this->applyToShipping;
    }

    public function getTax($taxSubtotal, $shipping = 0)
    {
        $newTaxSubtotal = $taxSubtotal;
        if ($this->applyToShipping) {
            $newTaxSubtotal += $shipping;
        }

        return (int) round($newTaxSubtotal * ($this->rate / 100));
    }

    public function getView()
    {
        return new View\TaxRate($this);
    }

    public function getDTOBuilder()
    {
        return new TaxRateDTOBuilder($this);
    }
}
