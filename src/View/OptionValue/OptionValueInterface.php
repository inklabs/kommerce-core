<?php
namespace inklabs\kommerce\View\OptionValue;

interface OptionValueInterface
{
    public function export();
    public function withOptionType();
    public function withAllData();
}
