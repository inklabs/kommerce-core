<?php
namespace inklabs\kommerce\Lib;

interface UuidInterface extends \JsonSerializable, \Serializable
{
    /**
     * @param UuidInterface $other
     * @return int -1, 0 or 1
     */
    public function compareTo(UuidInterface $other);

    /**
     * @param mixed $other
     * @return bool
     */
    public function equals($other);

    /**
     * 16-byte string (big-endian byte order)
     *
     * @return string
     */
    public function getBytes();

    /**
     * @return string
     */
    public function getHex();

    /**
     * @return string
     */
    public function toString();
}
