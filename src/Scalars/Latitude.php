<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\SerializationError;
use GraphQL\Language\AST\FloatValueNode;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\Node;
use GraphQL\Language\Printer;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

class Latitude extends ScalarType
{
    public ?string $description = 'The `Latitude` scalar type is any number between -90 and +90 degrees.';

    /**
     * @param mixed $value
     */
    private static function isValid($value): bool
    {
        return is_numeric($value) && abs((float) $value) <= 90;
    }

    public function serialize($value): ?float
    {
        if (self::isValid($value)) {
            return (float) $value;
        }

        if (!$value) {
            return null;
        }

        throw new SerializationError(sprintf(
            'Invalid latitude: %s',
            Utils::printSafe($value)
        ));
    }

    public function parseValue($value): ?float
    {
        if (self::isValid($value)) {
            return (float) $value;
        }

        if (!$value) {
            return null;
        }

        throw new Error(sprintf(
            'Invalid latitude: %s',
            Utils::printSafe($value)
        ));
    }

    public function parseLiteral(Node $valueNode, array $variables = null): ?float
    {
        if (($valueNode instanceof FloatValueNode || $valueNode instanceof IntValueNode) && self::isValid($valueNode->value)) {
            return (float) $valueNode->value;
        }

        if (!($valueNode->value ?? null)) {
            return null;
        }

        throw new Error(sprintf(
            'Invalid latitude: %s',
            Printer::doPrint($valueNode)
        ));
    }
}
