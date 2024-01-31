<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

final class MyRegex extends Regex
{
    public ?string $description = 'Bar';

    public static function regex(): string
    {
        return /** @lang RegExp */ '/foo/';
    }
}
