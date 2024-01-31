<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\Error;
use GraphQL\Language\Printer;
use GraphQL\Type\Definition\ScalarType;
use JsonException;

class JSON extends ScalarType
{
    public ?string $description /** @lang Markdown */
        = 'Arbitrary data encoded in JavaScript Object Notation. See https://www.json.org.';

    public function serialize($value): string
    {
        return json_encode($value, JSON_THROW_ON_ERROR);
    }

    public function parseValue($value)
    {
        return $this->decodeJSON($value);
    }

    public function parseLiteral($valueNode, array $variables = null)
    {
        if (! property_exists($valueNode, 'value')) {
            $withoutValue = Printer::doPrint($valueNode);
            throw new Error("Can not parse literals without a value: {$withoutValue}.");
        }

        return $this->decodeJSON($valueNode->value);
    }

    /**
     * Try to decode a user-given JSON value.
     *
     * @param mixed $value A user given JSON
     *
     * @throws Error
     *
     * @return mixed The decoded value
     */
    protected function decodeJSON($value)
    {
        try {
            return json_decode((string) $value, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new Error(
                $jsonException->getMessage(),
                null,
                null,
                null,
                null,
                $jsonException
            );
        }
    }
}
