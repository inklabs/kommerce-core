<?php
namespace inklabs\kommerce\Exception;

class AttachmentException extends Kommerce400Exception
{
    const ATTACHMENT_NOT_ALLOWED = 1;

    public static function notAllowed()
    {
        return new self('Attachment not allowed', self::ATTACHMENT_NOT_ALLOWED);
    }
}
