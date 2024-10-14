<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class AccountRequest extends Request implements RequestInterface
{
    private string $name;
    private string $password;
    private string $newPassword;
    private string $email;
    private string $createdAt;
    private array $image;
    private string $imageTmpName;
    private string $imageType;
    private string $imageSize;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->name = $this->request->getSessionParam('user', 'username');
    }

    public function fromGetRequest()
    {
        if ($this->request->getSession('user') !== null) {
            $this->email = $this->request->getSessionParam('user', 'email');
            $this->createdAt = $this->request->getSessionParam('user', 'createdAt')->format("Y-m-d H:i:s");
        }
    }

    public function fromPostRequest()
    {
        if (!empty($this->request->getRequest())){
            $this->password = $this->request->getRequestParam('currentPassword');
            $this->newPassword = $this->request->getRequestParam('newPassword');
        }
       if (!empty($this->request->getFiles())){
           $this->image = $this->request->getFiles();
           $this->imageTmpName = $this->request->getFileParam('image', 'tmp_name');
           $this->imageType = $this->request->getFileParam('image', 'type');
           $this->imageSize = $this->request->getFileParam('image', 'size');
       }

    }

    public function fromFILES()
    {

    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getImage(): array
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getImageSize(): string
    {
        return $this->imageSize;
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


}