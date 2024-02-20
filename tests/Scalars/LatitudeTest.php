<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\SerializationError;
use PHPUnit\Framework\TestCase;

final class LatitudeTest extends TestCase
{
    public function testSerializeThrowsIfLatitudeIsInvalid(): void
    {
        $bigInt = new Latitude();

        $this->expectExceptionObject(new SerializationError('Invalid latitude: "foo"'));
        $bigInt->serialize('foo');
    }

    public function testSerializeThrowsIfLatitudeIsOutOfBounds(): void
    {
        $bigInt = new Latitude();

        $this->expectExceptionObject(new SerializationError('Invalid latitude: 91.2'));
        $bigInt->serialize(91.2);
    }

    public function testSerializePassesWhenLatitudeIsBlank(): void
    {
        $serializedResult = (new Latitude())->serialize('');

        self::assertNull($serializedResult);
    }

    public function testSerializePassesWhenLatitudeIsValid(): void
    {
        $serializedResult = (new Latitude())->serialize(89.3252358);

        self::assertSame(89.3252358, $serializedResult);
    }

    public function testSerializePassesWhenLatitudeIsValidAsString(): void
    {
        $serializedResult = (new Latitude())->serialize('89.3252358');

        self::assertSame(89.3252358, $serializedResult);
    }

    public function testParseLatitudeIsBlank(): void
    {
        $parsedResult = (new Latitude())->parseValue('');

        self::assertNull($parsedResult);
    }

    public function testParseLatitudeIsValid(): void
    {
        $parsedResult = (new Latitude())->parseValue('89.3252358');

        self::assertSame(89.3252358, $parsedResult);
    }
}
