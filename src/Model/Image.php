<?php

namespace app\Model;

class Image
{
    private string $imageName;
    private string $imageTmpName;
    private string $imageType;
    private int $imageSize;

    public function __construct(string $imageName, string $imageTmpName, string $imageType, int $imageSize)
    {
        $this->setImageName($imageName);
        $this->setImageTmpName($imageTmpName);
        $this->setImageType($imageType);
        $this->setImageSize($imageSize);
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

    /**
     * @param string $imageName
     */
    public function setImageName(string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @param string $imageTmpName
     */
    public function setImageTmpName(string $imageTmpName): void
    {
        $this->imageTmpName = $imageTmpName;
    }

    /**
     * @param string $imageType
     */
    public function setImageType(string $imageType): void
    {
        $this->imageType = $imageType;
    }

    /**
     * @param int $imageSize
     */
    public function setImageSize(int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

}