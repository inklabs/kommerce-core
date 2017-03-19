<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Lib\ReferenceNumber\HashSegmentReferenceNumberGenerator;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberRepositoryInterface;

class ManualSeedHashSegmentReferenceNumberGenerator extends HashSegmentReferenceNumberGenerator
{
    /** @var string[] */
    private $seeds;

    public function __construct(ReferenceNumberRepositoryInterface $repository, array $seeds)
    {
        parent::__construct($repository);
        $this->seeds = $seeds;
    }

    protected function generateHashSegments()
    {
        if (empty($this->seeds)) {
            return parent::generateHashSegments();
        } else {
            return array_shift($this->seeds);
        }
    }
}
