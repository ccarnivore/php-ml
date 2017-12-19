<?php

declare(strict_types=1);

namespace Phpml;

use Phpml\Exception\FileException;
use Phpml\Exception\SerializeException;

class ModelManager
{
    public function saveToFile(Estimator $estimator, string $filePath): void
    {
        if (!is_writable(dirname($filePath))) {
            throw FileException::cantSaveFile(basename($filePath));
        }

        $serialized = serialize($estimator);
        if (empty($serialized)) {
            throw SerializeException::cantSerialize(gettype($estimator));
        }

        $result = file_put_contents($filePath, $serialized, LOCK_EX);
        if ($result === false) {
            throw FileException::cantSaveFile(basename($filePath));
        }
    }

    public function restoreFromFile(string $filePath): Estimator
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw FileException::cantOpenFile(basename($filePath));
        }

        $object = unserialize(file_get_contents($filePath));
        if ($object === false) {
            throw SerializeException::cantUnserialize(basename($filePath));
        }

        return $object;
    }

    public function resetFile(string $filePath): void
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw FileException::cantOpenFile(basename($filePath));
        }

        if (!unlink($filePath)) {
            throw FileException::cantDeleteFile(basename($filePath));
        }
    }
}
