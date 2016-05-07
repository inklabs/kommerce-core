<?php
namespace inklabs\kommerce\Exception;

class AttachmentException extends Kommerce400Exception
{
    const ATTACHMENT_NOT_ALLOWED = 0;

    public static function notAllowed()
    {
        return new self('Attachment not allowed', self::ATTACHMENT_NOT_ALLOWED);
    }
}
