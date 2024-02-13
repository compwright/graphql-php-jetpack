<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use PHPUnit\Framework\TestCase;

final class UsStateTest extends TestCase
{
    public function testSerializeThrowsIfUnserializableValueIsGiven(): void
    {
        $email = new UsState();
        $object = new class () {};

        $this->expectExceptionObject(new InvariantViolation('The given value can not be coerced to a string: object.'));
        $email->serialize($object);
    }

    public function testSerializeThrowsIfStateIsInvalid(): void
    {
        $email = new UsState();

        $this->expectExceptionObject(new InvariantViolation('The given string "foo" is not a valid State.'));
        $email->serialize('foo');
    }

    public function testSerializePassesWhenStateIsBlank(): void
    {
        $email = new UsState();
        $this->assertSame('', $email->serialize(''));
    }

    public function testSerializePassesWhenStateIsValid(): void
    {
        $serializedResult = (new UsState())->serialize('SC');

        self::assertSame('SC', $serializedResult);
    }

    public function testParseValueThrowsIfStateIsInvalid(): void
    {
        $email = new UsState();

        $this->expectExceptionObject(new Error('The given string "foo" is not a valid State.'));
        $email->parseValue('foo');
    }

    public function testParseValuePassesIfStateIsBlank(): void
    {
        self::assertSame(
            '',
            (new UsState())->parseValue('')
        );
    }

    public function testParseValuePassesIfStateIsValid(): void
    {
        self::assertSame(
            'SC',
            (new UsState())->parseValue('SC')
        );
    }

    public function testParseLiteralThrowsIfNotValidEmail(): void
    {
        $email = new UsState();
        $stringValueNode = new StringValueNode(['value' => 'foo']);

        $this->expectExceptionObject(new Error('The given string "foo" is not a valid State.'));
        $email->parseLiteral($stringValueNode);
    }

    public function testParseLiteralPassesIfStateIsBlank(): void
    {
        self::assertSame(
            '',
            (new UsState())->parseLiteral(new StringValueNode(['value' => '']))
        );
    }

    public function testParseLiteralPassesIfStateIsValid(): void
    {
        self::assertSame(
            'SC',
            (new UsState())->parseLiteral(new StringValueNode(['value' => 'SC']))
        );
    }
}
