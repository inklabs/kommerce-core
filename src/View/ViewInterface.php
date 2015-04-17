<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Service\Pricing;

interface ViewInterface
{
    /**
     * @return ViewInterface
     */
    public function export();

    /**
     * @return ViewInterface
     */
    //public function withAllData();
}
