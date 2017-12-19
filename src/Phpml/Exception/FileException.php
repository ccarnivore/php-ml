<?php

declare(strict_types=1);

namespace Phpml\Exception;

use Exception;

class FileException extends Exception
{
    /**
     * @param string $filePath
     *
     * @return FileException
     */
    public static function missingFile(string $filePath): self
    {
        return new self(sprintf('File "%s" missing.', $filePath));
    }

    /**
     * @param string $filePath
     *
     * @return FileException
     */
    public static function cantOpenFile(string $filePath): self
    {
        return new self(sprintf('File "%s" can\'t be open.', $filePath));
    }

    /**
     * @param string $filePath
     *
     * @return FileException
     */
    public static function cantSaveFile(string $filePath): self
    {
        return new self(sprintf('File "%s" can\'t be saved.', $filePath));
    }

    /**
     * @param string $filePath
     *
     * @return FileException
     */
    public static function cantDeleteFile(string $filePath): self
    {
        return new self(sprintf('File "%s" can\'t be deleted.', $filePath));
    }
}
