<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testSerializeThrowsIfUnserializableValueIsGiven(): void
    {
        $email = new Email();
        $object = new class () {};

        $this->expectExceptionObject(new InvariantViolation('The given value can not be coerced to a string: object.'));
        $email->serialize($object);
    }

    public function testSerializeThrowsIfEmailIsInvalid(): void
    {
        $email = new Email();

        $this->expectExceptionObject(new InvariantViolation('The given string "foo" is not a valid Email.'));
        $email->serialize('foo');
    }

    public function testSerializePassesWhenEmailIsBlank(): void
    {
        $serializedResult = (new Email())->serialize('');

        self::assertSame('', $serializedResult);
    }

    public function testSerializePassesWhenEmailIsValid(): void
    {
        $serializedResult = (new Email())->serialize('foo@bar.com');

        self::assertSame('foo@bar.com', $serializedResult);
    }

    public function testParseValueThrowsIfEmailIsInvalid(): void
    {
        $email = new Email();

        $this->expectExceptionObject(new Error('The given string "foo" is not a valid Email.'));
        $email->parseValue('foo');
    }

    public function testParseValuePassesIfEmailIsBlank(): void
    {
        self::assertSame(
            '',
            (new Email())->parseValue('')
        );
    }

    public function testParseValuePassesIfEmailIsValid(): void
    {
        self::assertSame(
            'foo@bar.com',
            (new Email())->parseValue('foo@bar.com')
        );
    }

    public function testParseLiteralThrowsIfNotValidEmail(): void
    {
        $email = new Email();
        $stringValueNode = new StringValueNode(['value' => 'foo']);

        $this->expectExceptionObject(new Error('The given string "foo" is not a valid Email.'));
        $email->parseLiteral($stringValueNode);
    }

    public function testParseLiteralPassesIfEmailIsBlank(): void
    {
        self::assertSame(
            '',
            (new Email())->parseLiteral(new StringValueNode(['value' => '']))
        );
    }

    public function testParseLiteralPassesIfEmailIsValid(): void
    {
        self::assertSame(
            'foo@bar.com',
            (new Email())->parseLiteral(new StringValueNode(['value' => 'foo@bar.com']))
        );
    }
}
