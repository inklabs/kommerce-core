<?php
namespace inklabs\kommerce\View\OptionType;

interface OptionTypeInterface
{
    public function export();
    public function withOptionValues();
    public function withTags();
    public function withAllData();
}
