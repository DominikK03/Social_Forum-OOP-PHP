<?php

namespace app\Service\Validator;

use app\Util\StaticValidator;

class CommentValidator
{
    public function validate(string $commentContent)
    {
        StaticValidator::assertNotEmpty($commentContent);
    }
}