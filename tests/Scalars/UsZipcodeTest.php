<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use PHPUnit\Framework\TestCase;

final class UsZipcodeTest extends TestCase
{
    public function testSerializeThrowsIfUnserializableValueIsGiven(): void
    {
        $email = new UsZipcode();
        $object = new class () {};

        $this->expectExceptionObject(new InvariantViolation('The given value can not be coerced to a string: object.'));
        $email->serialize($object);
    }

    public function testSerializeThrowsIfZipcodeIsInvalid(): void
    {
        $email = new UsZipcode();

        $this->expectExceptionObject(new InvariantViolation('The given value "foo" is not a valid Zipcode.'));
        $email->serialize('foo');
    }

    public function testSerializePassesWhenZipcodeIsBlank(): void
    {
        $email = new UsZipcode();
        $this->assertSame('', $email->serialize(''));
    }

    public function testSerializePassesWhenZipcodeIsValid(): void
    {
        $serializedResult = (new UsZipcode())->serialize('29684');

        self::assertSame('29684', $serializedResult);
    }

    public function testParseValueThrowsIfZipcodeIsInvalid(): void
    {
        $email = new UsZipcode();

        $this->expectExceptionObject(new Error('The given value "foo" is not a valid Zipcode.'));
        $email->parseValue('foo');
    }

    public function testParseValuePassesIfZipcodeIsBlank(): void
    {
        self::assertSame(
            '',
            (new UsZipcode())->parseValue('')
        );
    }

    public function testParseValuePassesIfZipcodeIsValid(): void
    {
        self::assertSame(
            '29684',
            (new UsZipcode())->parseValue('29684')
        );
    }

    public function testParseLiteralThrowsIfNotValidZipcode(): void
    {
        $email = new UsZipcode();
        $stringValueNode = new StringValueNode(['value' => 'foo']);

        $this->expectExceptionObject(new Error('The given value "foo" is not a valid Zipcode.'));
        $email->parseLiteral($stringValueNode);
    }

    public function testParseLiteralPassesIfZipcodeIsBlank(): void
    {
        self::assertSame(
            '',
            (new UsZipcode())->parseLiteral(new StringValueNode(['value' => '']))
        );
    }

    public function testParseLiteralPassesIfZipcodeIsValid(): void
    {
        self::assertSame(
            '29684',
            (new UsZipcode())->parseLiteral(new StringValueNode(['value' => '29684']))
        );
    }
}
