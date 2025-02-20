<?php

namespace app\Util;
use app\Exception\FileNotFoundException;

class FileSystem
{
    /**
     * @throws FileNotFoundException
     */
    public static function readFile(string $path): string
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException();
        }
        return file_get_contents($path);
    }
    public static function moveFile(string $tmpName, string $name)
    {
        move_uploaded_file($tmpName, $name);
    }
    public static function deleteFile(string $fileName)
    {
        if (file_exists($fileName)){
            unlink($fileName);
        }
    }
}
