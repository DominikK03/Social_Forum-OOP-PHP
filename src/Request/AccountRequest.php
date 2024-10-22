<?php

namespace app\Request;

use AllowDynamicProperties;
use app\Core\HTTP\Request\Request;

#[AllowDynamicProperties] class AccountRequest extends Request implements RequestInterface
{
    private array $userSession;
    private ?string $currentPassword;
    private string $deletePassword;
    private ?string $newPassword;
    private string $imageTmpName;
    private string $imageType;
    private string $imageSize;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function fromRequest()
    {
        if ($this->request->getSession('user') !== null) {
            $this->userSession = $this->request->getSession('user');
        }
        if ($this->request->getMethod() == "POST") {
            if (!empty($this->request->getFiles())) {
                $this->imageTmpName = $this->request->getFileParam('image', 'tmp_name');
                $this->imageType = $this->request->getFileParam('image', 'type');
                $this->imageSize = $this->request->getFileParam('image', 'size');
            }
            if (!empty($this->request->getRequestParam('deletePassword'))) {
                $this->deletePassword = htmlspecialchars($this->request->getRequestParam('deletePassword'));
            }
            if (!is_null($this->request->getRequestParam('currentPassword'))) {
                $this->currentPassword = htmlspecialchars($this->request->getRequestParam('currentPassword'));
                $this->newPassword = htmlspecialchars($this->request->getRequestParam('newPassword'));
            }
        }
    }

    /**
     * @return string
     */
    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    /**
     * @return string
     */
    public function getNewPassword(): string
    {
        return $this->newPassword;
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

    /**
     * @return string
     */
    public function getDeletePassword(): string
    {
        return $this->deletePassword;
    }

    /**
     * @return array
     */
    public function getUserSession(): array
    {
        return $this->userSession;
    }
}