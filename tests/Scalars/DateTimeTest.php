<?php

declare(strict_types=1);

namespace Compwright\GraphqlPhpJetpack\Scalars;

final class DateTimeTest extends DateScalarTestBase
{
    public static function invalidDateValues(): iterable
    {
        yield from parent::invalidDateValues();

        yield "Can't have 30th February" => ['2020-02-30 01:02:03'];
        yield 'Date' => ['2020-02-01'];
        yield 'DateTimeTz' => ['2017-02-01T00:00:00Z'];
    }

    protected function scalarInstance(): DateScalar
    {
        return new DateTime();
    }

    public static function validDates(): iterable
    {
        yield ['2020-04-20 23:51:15', '2020-04-20T23:51:15.000000+00:00'];
    }
}
