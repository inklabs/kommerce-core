<?php
namespace inklabs\kommerce\Lib;

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

    /**
     * @param string $file
     * @throws \InvalidArgumentException
     */
    public function __construct($file)
    {
        if (! file_exists($file)) {
            throw new \InvalidArgumentException($file);
        }

        // Use this in case the file has Windows `\r` line endings.
        //ini_set('auto_detect_line_endings', true);

        $this->fileHandle = fopen($file, 'r');
    }

    public function rewind()
    {
        if ($this->key > 0) {
            $this->key = 0;
            rewind($this->fileHandle);
        }

        $this->next();
    }

    public function current()
    {
        return $this->currentElement;
    }

    public function key()
    {
        return $this->key;
    }

    public function next()
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

    public function valid()
    {
        return ! feof($this->fileHandle);
    }
}
