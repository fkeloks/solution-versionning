<?php

namespace ESGI\Core\Upload\Types;

class VideoUploadType implements UploadTypeInterface
{
    public static function getExtensions(): array
    {
        return ['mp4', 'webm', 'ogg'];
    }

    public static function getMimeTypes(): array
    {
        return ['video/mp4', 'video/webm', 'video/ogg'];
    }
}
