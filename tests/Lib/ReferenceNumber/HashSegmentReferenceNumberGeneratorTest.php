<?php
namespace inklabs\kommerce\Lib\ReferenceNumber;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\RuntimeException;
use inklabs\kommerce\tests\Helper\Lib\ReferenceNumber\AlwaysFalseReferenceNumberRepository;
use inklabs\kommerce\tests\Helper\Lib\ReferenceNumber\AlwaysTrueReferenceNumberRepository;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class HashSegmentReferenceNumberGeneratorTest extends EntityRepositoryTestCase
{
    /** @var HashSegmentReferenceNumberGenerator */
    protected $hashSegmentGenerator;

    /** @var ReferenceNumberRepositoryInterface */
    protected $referenceNumberRepository;

    protected $metaDataClassNames = [
        Order::class,
        TaxRate::class,
        User::class,
    ];

    public function testGenerate()
    {
        // Given
        $hashSegmentGenerator = new HashSegmentReferenceNumberGenerator(new AlwaysFalseReferenceNumberRepository());

        // When
        $referenceNumber = $hashSegmentGenerator->generate();

        // Then
        $pieces = explode('-', $referenceNumber);
        $this->assertCount(3, $pieces);
        $this->assertSame(3, strlen($pieces[0]));
        $this->assertSame(7, strlen($pieces[1]));
        $this->assertSame(7, strlen($pieces[2]));
    }

    public function testGenerateWithCustomSegments()
    {
        // Given
        $hashSegmentGenerator = new HashSegmentReferenceNumberGenerator(new AlwaysFalseReferenceNumberRepository());
        $hashSegmentGenerator->setSegments([1, 2, 3, 4, 5]);

        // When
        $referenceNumber = $hashSegmentGenerator->generate();

        // Then
        $pieces = explode('-', $referenceNumber);
        $this->assertCount(5, $pieces);
        $this->assertSame(1, strlen($pieces[0]));
        $this->assertSame(2, strlen($pieces[1]));
        $this->assertSame(3, strlen($pieces[2]));
        $this->assertSame(4, strlen($pieces[3]));
        $this->assertSame(5, strlen($pieces[4]));
    }

    public function testGenerateThrowsException()
    {
        // Given
        $hashSegmentGenerator = new HashSegmentReferenceNumberGenerator(new AlwaysTrueReferenceNumberRepository());

        // Then
        $this->setExpectedException(
            RuntimeException::class,
            'Lookup limit reached'
        );

        // When
        $hashSegmentGenerator->generate();
    }
}
