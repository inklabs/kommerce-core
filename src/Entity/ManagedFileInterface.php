<?php
namespace inklabs\kommerce\Entity;

interface ManagedFileInterface
{
    public function getUri(): string;
    public function getFullPath(): string;
    public function getImageType(): int;
    public function getMimeType(): string;
    public function getWidth(): int;
    public function getHeight(): int;
}
