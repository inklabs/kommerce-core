<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class TaxRate implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string|null */
    protected $state;

    /** @var string|null */
    protected $zip5;

    /** @var string|null */
    protected $zip5From;

    /** @var string|null */
    protected $zip5To;

    /** @var double */
    protected $rate;

    /** @var boolean */
    protected $applyToShipping;

    public function __construct(UuidInterface $id = null)
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

    public static function createZip5(
        string $zip5,
        float $rate,
        bool $applyToShipping,
        UuidInterface $id = null
    ): TaxRate {
        $taxRate = new self($id);
        $taxRate->setZip5($zip5);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);
        return $taxRate;
    }

    public static function createZip5Range(
        string $zip5From,
        string $zip5To,
        float $rate,
        bool $applyToShipping,
        UuidInterface $id = null
    ): TaxRate {
        $taxRate = new self($id);
        $taxRate->setZip5From($zip5From);
        $taxRate->setZip5To($zip5To);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);
        return $taxRate;
    }

    public static function createState(
        string $state,
        float $rate,
        bool $applyToShipping,
        UuidInterface $id = null
    ): TaxRate {
        $taxRate = new self($id);
        $taxRate->setState($state);
        $taxRate->setRate($rate);
        $taxRate->setApplyToShipping($applyToShipping);
        return $taxRate;
    }

    public function setState(?string $state)
    {
        $this->state = $state;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setZip5(?string $zip5 = null)
    {
        $this->zip5 = $zip5;
    }

    public function getZip5(): ?string
    {
        return $this->zip5;
    }

    public function setZip5From(?string $zip5From = null)
    {
        $this->zip5From = $zip5From;
    }

    public function getZip5From(): ?string
    {
        return $this->zip5From;
    }

    public function setZip5To(?string $zip5To = null)
    {
        $this->zip5To = $zip5To;
    }

    public function getZip5To(): ?string
    {
        return $this->zip5To;
    }

    public function setRate(float $rate)
    {
        $this->rate = $rate;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setApplyToShipping(bool $applyToShipping)
    {
        $this->applyToShipping = $applyToShipping;
    }

    public function getApplyToShipping(): bool
    {
        return $this->applyToShipping;
    }

    public function getTax(int $taxSubtotal, int $shipping = 0)
    {
        $newTaxSubtotal = $taxSubtotal;
        if ($this->applyToShipping) {
            $newTaxSubtotal += $shipping;
        }

        return (int) round($newTaxSubtotal * ($this->rate / 100));
    }

    public static function getValidStatesMap(): array
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
