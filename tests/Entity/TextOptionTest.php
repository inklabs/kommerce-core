<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\View;
use Symfony\Component\Validator\Validation;

class TextOptionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $textOption = new TextOption;
        $textOption->setType(TextOption::TYPE_TEXTAREA);
        $textOption->setName('Custom Message');
        $textOption->setDescription('Custom engraved message');
        $textOption->setSortOrder(0);
        $textOption->addTag(new Tag);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($textOption));
        $this->assertSame(TextOption::TYPE_TEXTAREA, $textOption->getType());
        $this->assertSame('Textarea', $textOption->getTypeText());
        $this->assertSame('Custom Message', $textOption->getName());
        $this->assertSame('Custom engraved message', $textOption->getDescription());
        $this->assertSame(0, $textOption->getSortOrder());
        $this->assertTrue($textOption->getTags()[0] instanceof Tag);
        $this->assertTrue($textOption->getView() instanceof View\TextOption);
    }
}
