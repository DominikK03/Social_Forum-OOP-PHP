<?php

namespace app\Service\Validator;

use app\Exception\FileIsntImageException;
use app\Exception\NotProperSizeException;
use app\Util\StaticValidator;

class ImageValidator
{

    public function validateImage(string $imageType, int $imageSize): void
    {
        $allowedTypes = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
        StaticValidator::assertInArray($imageType, $allowedTypes, FileIsntImageException::class);
        StaticValidator::assertLessThanOrEqual($imageSize, 1000000);
    }
}