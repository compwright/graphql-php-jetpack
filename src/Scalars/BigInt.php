<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

class BigInt extends Regex
{
    public ?string $description = <<<'DESCRIPTION'
An arbitrarily long sequence of digits that represents a big integer.
DESCRIPTION;

    public static function regex(): string
    {
        return "/\d+/";
    }
}
