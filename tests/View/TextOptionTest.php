<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Service;

class TextOptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $textOption = new Entity\TextOption;
        $textOption->addTag(new Entity\Tag);

        $viewTextOption = $textOption->getView()
            ->withAllData()
            ->export();

        $this->assertTrue($viewTextOption instanceof TextOption);
        $this->assertTrue($viewTextOption->tags[0] instanceof Tag);
    }
}
