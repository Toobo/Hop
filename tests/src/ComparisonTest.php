<?php
/*
 * This file is part of the toobo/hop.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Toobo\Hop\Tests;

use PHPUnit\Framework\TestCase;
use Toobo\Hop as _;

class ComparisonTest extends TestCase
{

    public function testIs()
    {
        $is = _\is(['foo']);

        static::assertFalse($is(['foo', 'bar']));
        static::assertFalse($is(['bar']));
        static::assertFalse($is(['foo ']));
        static::assertFalse($is('foo'));
        static::assertTrue($is(['foo']));
    }

    public function testIsObject()
    {
        $object = new \ArrayObject(['foo']);
        $is = _\is($object);

        static::assertFalse($is(['foo']));
        static::assertFalse($is(new \ArrayObject(['foo'])));
        static::assertTrue($is($object));
    }

    public function testIsNot()
    {
        $object = new \ArrayObject(['foo']);
        $isNot = _\isNot($object);

        static::assertTrue($isNot(['foo']));
        static::assertTrue($isNot(new \ArrayObject(['foo'])));
        static::assertFalse($isNot($object));
    }

    public function testEquals()
    {
        $cb = _\equals('');

        static::assertFalse($cb(' '));
        static::assertFalse($cb('c'));
        static::assertFalse($cb([]));
        static::assertFalse($cb('0'));
        static::assertTrue($cb(false));
        static::assertTrue($cb(null));
        static::assertTrue($cb(''));
    }

    public function testEqualsObject()
    {
        $object = new \ArrayObject(['foo']);
        $is = _\equals($object);

        static::assertFalse($is(['foo']));
        static::assertTrue($is(new \ArrayObject(['foo'])));
        static::assertTrue($is($object));
    }

    public function testNotEquals()
    {
        $cb = _\notEquals('');

        static::assertTrue($cb(' '));
        static::assertTrue($cb('c'));
        static::assertTrue($cb([]));
        static::assertTrue($cb('0'));
        static::assertFalse($cb(false));
        static::assertFalse($cb(null));
    }

    public function testMatch()
    {
        $match = _\match('/^x[1-9]+x$/');

        static::assertFalse($match('_0'));
        static::assertFalse($match('123456'));
        static::assertFalse($match('x123456'));
        static::assertFalse($match('123456x'));
        static::assertFalse($match('x0x'));
        static::assertTrue($match('x1x'));
    }

    public function testMatchEmpty()
    {
        $match = _\match('');

        static::assertFalse($match(''));
    }

    public function testNotMatch()
    {
        $notMatch = _\notMatch('/^x[1-9]+x$/');

        static::assertTrue($notMatch('_0'));
        static::assertTrue($notMatch('123456'));
        static::assertTrue($notMatch('x123456'));
        static::assertTrue($notMatch('123456x'));
        static::assertTrue($notMatch('x0x'));
        static::assertFalse($notMatch('x1x'));
    }

    public function testNotMatchEmpty()
    {
        $notMatch = _\notMatch('');

        static::assertTrue($notMatch(''));
    }

    public function testMoreThenFailsWithNonNumericValue()
    {
        $this->expectException(\TypeError::class);
        _\moreThanOrEqual('2');
    }

    public function testMoreThan()
    {
        $cb = _\moreThan(8.5);

        static::assertTrue($cb(8.6));
        static::assertTrue($cb(9));
        static::assertTrue($cb(125));
        static::assertFalse($cb(8.5));
        static::assertFalse($cb(8));
        static::assertFalse($cb(-8));
    }

    public function testMoreThanOfEqual()
    {
        $cb = _\moreThanOrEqual(8.5);

        static::assertTrue($cb(8.6));
        static::assertTrue($cb(9));
        static::assertTrue($cb(125));
        static::assertTrue($cb(8.5));
        static::assertFalse($cb(8));
        static::assertFalse($cb(-8));
    }

    public function testLessThan()
    {
        $cb = _\lessThan(-1);

        static::assertFalse($cb(0));
        static::assertFalse($cb(1));
        static::assertFalse($cb(-0.5));
        static::assertFalse($cb(-0.999));
        static::assertFalse($cb(-1));
        static::assertTrue($cb(-1.01));
        static::assertTrue($cb(-2));
    }

    public function testLessThanOrEqual()
    {
        $cb = _\lessThanOrEqual(-1);

        static::assertFalse($cb(0));
        static::assertFalse($cb(1));
        static::assertFalse($cb(-0.5));
        static::assertFalse($cb(-0.999));
        static::assertTrue($cb(-1));
        static::assertTrue($cb(-1.01));
        static::assertTrue($cb(-2));
    }

    public function testBetween()
    {
        $cb = _\between(-1, 3);

        static::assertTrue($cb(-1));
        static::assertTrue($cb(3));
        static::assertTrue($cb(0));
        static::assertTrue($cb(2));
        static::assertFalse($cb(-1.01));
        static::assertFalse($cb(3.01));
        static::assertFalse($cb(-2));
        static::assertFalse($cb(8));
    }

    public function testBetweenInner()
    {
        $cb = _\betweenInner(-1, 3);

        static::assertFalse($cb(-1));
        static::assertFalse($cb(3));
        static::assertTrue($cb(0));
        static::assertTrue($cb(2));
        static::assertFalse($cb(-1.01));
        static::assertFalse($cb(3.01));
        static::assertFalse($cb(-2));
        static::assertFalse($cb(8));
    }

    public function testBetweenLeft()
    {
        $cb = _\betweenLeft(-1, 3);

        static::assertTrue($cb(-1));
        static::assertFalse($cb(3));
        static::assertTrue($cb(0));
        static::assertTrue($cb(2));
        static::assertFalse($cb(-1.01));
        static::assertFalse($cb(3.01));
        static::assertFalse($cb(-2));
        static::assertFalse($cb(8));
    }

    public function testBetweenRight()
    {
        $cb = _\betweenRight(-1, 3);

        static::assertFalse($cb(-1));
        static::assertTrue($cb(3));
        static::assertTrue($cb(0));
        static::assertTrue($cb(2));
        static::assertFalse($cb(-1.01));
        static::assertFalse($cb(3.01));
        static::assertFalse($cb(-2));
        static::assertFalse($cb(8));
    }
}
