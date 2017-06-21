<?php
namespace inklabs\kommerce\Lib;

use Hamcrest\Description;
use Hamcrest\Matcher;
use Ramsey\Uuid\Uuid as RamseyUuid;
use Ramsey\Uuid\UuidInterface as RamseyUuidInterface;

class Uuid implements UuidInterface, Matcher
{
    /** @var RamseyUuidInterface */
    private $ramseyUuid;

    private function __construct(RamseyUuidInterface $ramseyUuid)
    {
        $this->ramseyUuid = $ramseyUuid;
    }

    public static function uuid4()
    {
        return new self(RamseyUuid::uuid4());
    }

    public static function fromBytes(string $uuidBytes)
    {
        return new self(RamseyUuid::fromBytes($uuidBytes));
    }

    public static function fromString(string $uuidString)
    {
        return new self(RamseyUuid::fromString($uuidString));
    }

    public static function fromShortString(string $uuidShortString)
    {
        return self::fromBytes(self::decodeBase64URLSafe($uuidShortString));
    }

    /**
     * @param UuidInterface $other
     * @return int -1, 0 or 1
     */
    public function compareTo(UuidInterface $other): int
    {
        $ramseyOther = RamseyUuid::fromBytes($other->getBytes());
        return $this->ramseyUuid->compareTo($ramseyOther);
    }

    /**
     * @param mixed $other
     * @return bool
     */
    public function equals($other): bool
    {
        if (! ($other instanceof UuidInterface)) {
            return false;
        }

        return (0 === $this->compareTo($other));
    }

    /**
     * 16-byte string (big-endian byte order)
     *
     * @return string
     */
    public function getBytes(): string
    {
        return $this->ramseyUuid->getBytes();
    }

    public function getHex(): string
    {
        return $this->ramseyUuid->getHex();
    }

    public function getShortString(): string
    {
        return self::encodeBase64URLSafe($this->getBytes());
    }

    public static function encodeBase64URLSafe(string $bytesString): string
    {
        return strtr(
            base64_encode($bytesString),
            [
                '+' => '-',
                '/' => '_',
                '=' => '',
            ]
        );
    }

    public static function decodeBase64URLSafe(string $bytesString): string
    {
        return base64_decode(strtr(
            $bytesString,
            [
                '-' => '+',
                '_' => '/',
            ]
        ));
    }

    public function toString(): string
    {
        return $this->ramseyUuid->toString();
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function jsonSerialize()
    {
        return $this->toString();
    }

    public function serialize(): string
    {
        return $this->toString();
    }

    public function unserialize($serialized)
    {
        $this->ramseyUuid = RamseyUuid::fromString($serialized);
    }

    public function matches($item): bool
    {
        return $this->equals($item);
    }

    public function describeTo(Description $description)
    {
        $description->appendValue($this->toString());
    }

    public function describeMismatch($item, Description $description)
    {
        $description
            ->appendText('was ')
            ->appendValue($item->toString());
    }
}
