<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Utils\Utils as GraphQLUtils;

class UsZipcode extends Regex
{
    public string $name = 'Zipcode';

    public ?string $description = 'A valid five- or nine-digit US zip code.';

    public static function regex(): string
    {
        return "/^(?:\d{5}(?:-?\d{4})?)?$/";
    }

    /** Construct the error message that occurs when the given string does not match the regex. */
    public static function unmatchedRegexMessage(string $value): string
    {
        $safeValue = GraphQLUtils::printSafeJson($value);

        return "The given value {$safeValue} is not a valid Zipcode.";
    }
}
