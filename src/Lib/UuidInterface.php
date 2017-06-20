<?php
namespace inklabs\kommerce\Lib;

interface UuidInterface extends \JsonSerializable, \Serializable
{
    /**
     * @param UuidInterface $other
     * @return int -1, 0 or 1
     */
    public function compareTo(UuidInterface $other): int;

    /**
     * @param mixed $other
     * @return bool
     */
    public function equals($other): bool;

    /**
     * 16-byte string (big-endian byte order)
     *
     * @return string
     */
    public function getBytes(): string;

    public function getHex(): string;
    public function getShortString(): string;
    public function toString(): string;
}
