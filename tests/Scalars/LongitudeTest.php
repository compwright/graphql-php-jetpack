<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\SerializationError;
use PHPUnit\Framework\TestCase;

final class LongitudeTest extends TestCase
{
    public function testSerializeThrowsIfLongitudeIsInvalid(): void
    {
        $bigInt = new Longitude();

        $this->expectExceptionObject(new SerializationError('Invalid longitude: "foo"'));
        $bigInt->serialize('foo');
    }

    public function testSerializeThrowsIfLongitudeIsOutOfBounds(): void
    {
        $bigInt = new Longitude();

        $this->expectExceptionObject(new SerializationError('Invalid longitude: 191.2'));
        $bigInt->serialize(191.2);
    }

    public function testSerializePassesWhenLongitudeIsBlank(): void
    {
        $serializedResult = (new Longitude())->serialize('');

        self::assertNull($serializedResult);
    }

    public function testSerializePassesWhenLongitudeIsValid(): void
    {
        $serializedResult = (new Longitude())->serialize(139.3252358);

        self::assertSame(139.3252358, $serializedResult);
    }

    public function testSerializePassesWhenLongitudeIsValidAsString(): void
    {
        $serializedResult = (new Longitude())->serialize('139.3252358');

        self::assertSame(139.3252358, $serializedResult);
    }

    public function testParseLongitudeIsBlank(): void
    {
        $parsedResult = (new Longitude())->parseValue('');

        self::assertNull($parsedResult);
    }

    public function testParseLongitudeIsValid(): void
    {
        $parsedResult = (new Longitude())->parseValue('139.3252358');

        self::assertSame(139.3252358, $parsedResult);
    }
}
