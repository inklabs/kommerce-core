<?php
namespace inklabs\kommerce\tests\Action\Tag;

use inklabs\kommerce\Service\TagService;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTagRepository;

abstract class AbstractTagHandlerTestCase extends DoctrineTestCase
{
    /** @var FakeTagRepository */
    protected $tagRepository;

    /** @var TagService */
    protected $tagService;

    public function setUp()
    {
        $this->tagRepository = new FakeTagRepository;
        $this->tagService = new TagService($this->tagRepository);
    }
}
