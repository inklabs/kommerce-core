<?php
namespace inklabs\kommerce\Entity;

class TaxRate
{
    use Accessors;

    public $id;
    public $state;
    public $zip5;
    public $zip5_from;
    public $zip5_to;
    public $rate = 0.0;
    public $apply_to_shipping;
    public $created;
    public $updated;

    public function getTax($tax_subtotal, $shipping)
    {
        if ($this->apply_to_shipping) {
            $tax_subtotal += $shipping;
        }

        return (int) round($tax_subtotal * ($this->rate / 100));
    }
}
