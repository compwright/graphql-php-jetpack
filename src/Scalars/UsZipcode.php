<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

class UsZipcode extends Regex
{
    public string $name = 'Zipcode';

    public ?string $description = 'A valid five- or nine-digit US zip code.';

    public static function regex(): string
    {
        return "/^\d{5}(?:-?\d{4})?$/";
    }
}
