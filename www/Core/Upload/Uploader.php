<?php

namespace ESGI\Core\Upload;

use ESGI\Core\Upload\Types\UploadTypeInterface;
use RuntimeException;

class Uploader
{
    /**
     * Returns directory upload path
     *
     * @param string|null $folder
     *
     * @return string
     */
    public static function getUploadPath(?string $folder = null): string
    {
        $path = BASE_PATH . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
        if ($folder !== null) {
            $path .= $folder . DIRECTORY_SEPARATOR;
        }

        return $path;
    }

    /**
     * Upload file to uploads/ directory
     *
     * @param string $fieldName
     * @param UploadTypeInterface[]|string[] $types
     * @param string|null $folder
     * @param string|null $name
     *
     * @return string
     */
    public static function upload(
        string $fieldName,
        array $types = [],
        ?string $folder = null,
        ?string $name = null
    ): string {
        if (!isset($_FILES[$fieldName])) {
            throw new RuntimeException('No file to upload.');
        }

        // Get filename.
        $filename = explode('.', $_FILES[$fieldName]['name']);

        // Validate uploaded files.
        // Do not use $_FILES['file']['type'] as it can be easily forged.
        $fileInfos = finfo_open(FILEINFO_MIME_TYPE);

        // Get temp file name.
        $tmpName = $_FILES[$fieldName]['tmp_name'];

        // Allowed mime types & extensions
        $allowedMimeTypes = [];
        $allowedExtensions = [];

        foreach ($types as $type) {
            foreach ($type::getMimeTypes() as $mimeType) {
                $allowedMimeTypes[] = $mimeType;
            }

            foreach ($type::getExtensions() as $extension) {
                $allowedExtensions[] = $extension;
            }
        }

        // Get mime type. You must include fileinfo PHP extension.
        $mimeType = finfo_file($fileInfos, $tmpName);

        // Get extension.
        $extension = end($filename);

        // Validate file.
        if (
            !in_array(strtolower($mimeType), $allowedMimeTypes, true) ||
            !in_array(strtolower($extension), $allowedExtensions, true)
        ) {
            throw new RuntimeException('File does not meet the validation.');
        }

        if ($name) {
            $newName = $name . '.' . $extension;
        } else {
            // Generate new random name.
            $newName = sha1(microtime()) . '.' . $extension;
        }

        // Save file in the uploads folder.
        move_uploaded_file($tmpName, self::getUploadPath($folder) . $newName);

        // Returns link
        return url('homepage') . 'uploads/' . ($folder ? $folder . '/' : '') . $newName;
    }

    /**
     * Returns list of uploaded files
     *
     * @return array
     */
    public static function getUploadedFiles(): array
    {
        $files = glob(self::getUploadPath() . '*.*');

        return array_map(static function ($file) {
            $fileInfos = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($fileInfos, $file);

            return [
                'url' => url('homepage') . 'uploads/' . basename($file),
                'type' => explode('/', $mimeType)[0],
                'mime_type' => $mimeType
            ];
        }, $files);
    }
}
