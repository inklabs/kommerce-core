<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class TaxRate implements IdEntityInterface, ValidationInterface
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

    /** @var boolean */
    protected $applyToShipping;

    /**
     * @param UuidInterface $id
     */
    public function __construct($id = null)
    {
        $this->setId($id);
        $this->setCreated();
        $this->applyToShipping = false;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('state', new Assert\Length([
            'min' => 2,
            'max' => 2,
        ]));
        $metadata->addPropertyConstraint('state', new Assert\Choice([
            'choices' => array_keys(self::getValidStatesMap()),
            'message' => 'Must be a valid state code',
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

    /**
     * @param string $zip5
     * @param float $rate
     * @param bool $applyToShipping
     * @param UuidInterface $id
     * @return TaxRate
     */
    public static function createZip5($zip5, $rate, $applyToShipping, $id = null)
    {
        $taxRate = new self($id);
        $taxRate->setZip5($zip5);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);
        return $taxRate;
    }

    /**
     * @param string $zip5From
     * @param string $zip5To
     * @param float $rate
     * @param bool $applyToShipping
     * @param UuidInterface $id
     * @return TaxRate
     */
    public static function createZip5Range($zip5From, $zip5To, $rate, $applyToShipping, $id = null)
    {
        $taxRate = new self($id);
        $taxRate->setZip5From($zip5From);
        $taxRate->setZip5To($zip5To);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);
        return $taxRate;
    }

    /**
     * @param string $state
     * @param float $rate
     * @param bool $applyToShipping
     * @param UuidInterface $id
     * @return TaxRate
     */
    public static function createState($state, $rate, $applyToShipping, $id = null)
    {
        $taxRate = new self($id);
        $taxRate->setState($state);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);
        return $taxRate;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $zip5
     */
    public function setZip5($zip5 = null)
    {
        if ($zip5 !== null) {
            $zip5 = (string) $zip5;
        }

        $this->zip5 = $zip5;
    }

    public function getZip5()
    {
        return $this->zip5;
    }

    /**
     * @param string $zip5From
     */
    public function setZip5From($zip5From = null)
    {
        if ($zip5From !== null) {
            $zip5From = (string) $zip5From;
        }

        $this->zip5From = $zip5From;
    }

    public function getZip5From()
    {
        return $this->zip5From;
    }

    /**
     * @param string $zip5To
     */
    public function setZip5To($zip5To = null)
    {
        if ($zip5To !== null) {
            $zip5To = (string) $zip5To;
        }

        $this->zip5To = $zip5To;
    }

    public function getZip5To()
    {
        return $this->zip5To;
    }

    /**
     * @param double $rate
     */
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

    public static function getValidStatesMap()
    {
        return array(
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'DC' => 'District Of Columbia',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',

            'GU' => 'Guam',
            'FM' => 'Federated States of Micronesia',
            'MH' => 'Marshall Islands',
            'PW' => 'Palau',
            'AA' => 'US Armed Forces - Americas',
            'AE' => 'US Armed Forces - Europe',
            'AP' => 'US Armed Forces - Pacific',
        );
    }
}
