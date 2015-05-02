<?php
namespace inklabs\kommerce\View;

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
