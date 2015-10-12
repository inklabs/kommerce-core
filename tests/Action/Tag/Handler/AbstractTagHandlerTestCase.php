<?php
namespace inklabs\kommerce\tests\Action\Tag\Handler;

use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

abstract class AbstractTagHandlerTestCase extends DoctrineTestCase
{
    /** @var FakeTagRepository */
    protected $fakeTagRepository;

    /** @var TagService */
    protected $tagService;

    /** @var Pricing */
    protected $pricing;

    public function setUp()
    {
        $this->fakeTagRepository = new FakeTagRepository;
        $this->tagService = new TagService($this->fakeTagRepository);
        $this->pricing = new Pricing;
    }
}
