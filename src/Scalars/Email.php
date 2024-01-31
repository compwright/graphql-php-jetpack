<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

class Email extends StringScalar
{
    public ?string $description /** @lang Markdown */
        = 'A [RFC 5321](https://tools.ietf.org/html/rfc5321) compliant email.';

    protected function isValid(string $stringValue): bool
    {
        return filter_var($stringValue, FILTER_VALIDATE_EMAIL) !== false;
    }
}
