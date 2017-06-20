<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Exception\InvalidArgumentException;
use Iterator;

class CSVIterator implements Iterator
{
    /** @var int */
    private $rowLength = 2048;

    /** @var array */
    private $currentElement;

    /** @var int */
    private $key;

    /** @var resource */
    private $fileHandle;

    /** @var string */
    private $delimiter = ',';

    /** @var string */
    private $enclosure = '"';

    /** @var string */
    private $escape = '\\';

    public function __construct(string $file)
    {
        if (! file_exists($file)) {
            throw new InvalidArgumentException($file);
        }

        // Use this in case the file has Windows `\r` line endings.
        //ini_set('auto_detect_line_endings', true);

        $this->fileHandle = fopen($file, 'r');
    }

    public function rewind(): void
    {
        if ($this->key > 0) {
            $this->key = 0;
            rewind($this->fileHandle);
        }

        $this->next();
    }

    public function current(): array
    {
        return $this->currentElement;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next(): void
    {
        $this->currentElement = fgetcsv(
            $this->fileHandle,
            $this->rowLength,
            $this->delimiter,
            $this->enclosure,
            $this->escape
        );

        $this->key++;
    }

    public function valid(): bool
    {
        return ! feof($this->fileHandle);
    }
}
