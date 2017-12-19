<?php

declare(strict_types=1);

namespace Phpml;

use Phpml\Exception\FileException;
use Phpml\Exception\SerializeException;

class ModelManager
{
    /**
     * @param Estimator $estimator
     * @param string $filepath
     *
     * @return void
     *
     * @throws FileException
     * @throws SerializeException
     */
    public function saveToFile(Estimator $estimator, string $filepath): void
    {
        if (!is_writable(dirname($filepath))) {
            throw FileException::cantSaveFile(basename($filepath));
        }

        $serialized = serialize($estimator);
        if (empty($serialized)) {
            throw SerializeException::cantSerialize(gettype($estimator));
        }

        $result = file_put_contents($filepath, $serialized, LOCK_EX);
        if ($result === false) {
            throw FileException::cantSaveFile(basename($filepath));
        }
    }

    /**
     * @param string $filePath
     *
     * @return Estimator
     *
     * @throws FileException
     * @throws SerializeException
     */
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

    /**
     * @param string $filePath
     *
     * @return void
     *
     * @throws FileException
     */
    public function reset(string $filePath): void
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw FileException::cantOpenFile(basename($filePath));
        }

        if (!unlink($filePath)) {
            throw FileException::cantDeleteFile(basename($filePath));
        }
    }
}
