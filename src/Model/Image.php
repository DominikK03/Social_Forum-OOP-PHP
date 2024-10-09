<?php

namespace app\Model;

class Image
{
    public function __construct(private string $imageName,
                                private string $imageTmpName,
                                private string $imageType,
                                private int    $imageSize)
    {
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @return string
     */
    public function getImageTmpName(): string
    {
        return $this->imageTmpName;
    }

    /**
     * @return string
     */
    public function getImageType(): string
    {
        return $this->imageType;
    }

    /**
     * @return int
     */
    public function getImageSize(): int
    {
        return $this->imageSize;
    }


}