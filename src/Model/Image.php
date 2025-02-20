<?php

namespace app\Model;
readonly class Image
{
    public function __construct(
        public string $imageName,
        public string $imageTmpName,
        public string $imageType,
        public int $imageSize
    )
    {
    }
}