<?php

namespace app\Request;

interface RequestInterface
{
    public function fromPostRequest();
    public function fromGetRequest();
}