<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\IntValueNode;
use GraphQL\Language\AST\NodeKind;
use GraphQL\Language\AST\StringValueNode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RegexTest extends TestCase
{
    /**
     * Provide the same Regex class using the different methods for instantiation.
     *
     * @return iterable<array{Regex}>
     */
    public static function regexClassProvider(): iterable
    {
        yield [
            new class () extends Regex {
                public string $name = 'MyRegex';

                public ?string $description = 'Bar';

                public static function regex(): string
                {
                    return /** @lang RegExp */ '/foo/';
                }
            },
        ];
        yield [
            new class (['name' => 'MyRegex', 'description' => 'Bar']) extends Regex {
                public static function regex(): string
                {
                    return /** @lang RegExp */ '/foo/';
                }
            },
        ];
        yield [
            new MyRegex(),
        ];
        yield [
            Regex::make('MyRegex', 'Bar', /** @lang RegExp */ '/foo/'),
        ];
    }

    #[DataProvider('regexClassProvider')]
    public function testCreateNamedRegexClass(Regex $regex): void
    {
        self::assertSame('MyRegex', $regex->name);
        self::assertSame('Bar', $regex->description);
    }

    #[DataProvider('regexClassProvider')]
    public function testSerializeThrowsIfUnserializableValueIsGiven(Regex $regex): void
    {
        $object = new class () {};

        $this->expectException(InvariantViolation::class);
        $regex->serialize($object);
    }

    #[DataProvider('regexClassProvider')]
    public function testSerializeThrowsIfRegexIsNotMatched(Regex $regex): void
    {
        $this->expectExceptionObject(new InvariantViolation(
            $regex::unmatchedRegexMessage('bar')
        ));

        $regex->serialize('bar');
    }

    #[DataProvider('regexClassProvider')]
    public function testSerializePassesWhenRegexMatches(Regex $regex): void
    {
        $serializedResult = $regex->serialize('foo');

        self::assertSame('foo', $serializedResult);
    }

    #[DataProvider('regexClassProvider')]
    public function testSerializePassesForStringableObject(Regex $regex): void
    {
        $serializedResult = $regex->serialize(
            new class () {
                public function __toString(): string
                {
                    return 'Contains foo right?';
                }
            }
        );

        self::assertSame('Contains foo right?', $serializedResult);
    }

    #[DataProvider('regexClassProvider')]
    public function testParseValueThrowsIfValueCantBeString(Regex $regex): void
    {
        $object = new class () {};

        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches(/** @lang RegExp */ '/can not be coerced to a string/');
        $regex->parseValue($object);
    }

    #[DataProvider('regexClassProvider')]
    public function testParseValueThrowsIfValueDoesNotMatch(Regex $regex): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches(/** @lang RegExp */ '/did not match the regex/');
        $regex->parseValue('');
    }

    #[DataProvider('regexClassProvider')]
    public function testParseValuePassesOnMatch(Regex $regex): void
    {
        self::assertSame(
            'foo',
            $regex->parseValue('foo')
        );
    }

    #[DataProvider('regexClassProvider')]
    public function testParseLiteralThrowsIfNotString(Regex $regex): void
    {
        $intValueNode = new IntValueNode([]);

        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches(/** @lang RegExp */ '/' . NodeKind::INT . '/');
        $regex->parseLiteral($intValueNode);
    }

    #[DataProvider('regexClassProvider')]
    public function testParseLiteralThrowsIfValueDoesNotMatch(Regex $regex): void
    {
        $stringValueNode = new StringValueNode(['value' => 'asdf']);

        $this->expectException(Error::class);
        $this->expectExceptionMessageMatches(/** @lang RegExp */ '/did not match the regex/');
        $regex->parseLiteral($stringValueNode);
    }

    #[DataProvider('regexClassProvider')]
    public function testParseLiteralPassesOnMatch(Regex $regex): void
    {
        self::assertSame(
            'foo',
            $regex->parseLiteral(new StringValueNode(['value' => 'foo']))
        );
    }
}
