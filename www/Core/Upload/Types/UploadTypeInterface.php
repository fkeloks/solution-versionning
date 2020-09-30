<?php

namespace ESGI\Core\Upload\Types;

interface UploadTypeInterface
{
    /**
     * Returns allowed extensions
     *
     * @return string[]
     */
    public static function getExtensions(): array;

    /**
     * Returns allowed mime types
     *
     * @return string[]
     */
    public static function getMimeTypes(): array;
}
