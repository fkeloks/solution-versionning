<?php

namespace ESGI\Core\Upload\Types;

class ImageUploadType implements UploadTypeInterface
{
    public static function getExtensions(): array
    {
        return ['gif', 'jpeg', 'jpg', 'png', 'svg', 'blob'];
    }

    public static function getMimeTypes(): array
    {
        return ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png', 'image/svg+xml'];
    }
}
