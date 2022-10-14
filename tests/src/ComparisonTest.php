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
    /**
     * @test
     */
    public function testIs(): void
    {
        $is = _\is(['foo']);

        static::assertFalse($is(['foo', 'bar']));
        static::assertFalse($is(['bar']));
        static::assertFalse($is(['foo ']));
        static::assertFalse($is('foo'));
        static::assertTrue($is(['foo']));
    }

    /**
     * @test
     */
    public function testIsObject(): void
    {
        $object = new \ArrayObject(['foo']);
        $is = _\is($object);

        static::assertFalse($is(['foo']));
        static::assertFalse($is(new \ArrayObject(['foo'])));
        static::assertTrue($is($object));
    }

    /**
     * @test
     */
    public function testIsNot(): void
    {
        $object = new \ArrayObject(['foo']);
        $isNot = _\isNot($object);

        static::assertTrue($isNot(['foo']));
        static::assertTrue($isNot(new \ArrayObject(['foo'])));
        static::assertFalse($isNot($object));
    }

    /**
     * @test
     */
    public function testEquals(): void
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

    /**
     * @test
     */
    public function testEqualsObject(): void
    {
        $object = new \ArrayObject(['foo']);
        $is = _\equals($object);

        static::assertFalse($is(['foo']));
        static::assertTrue($is(new \ArrayObject(['foo'])));
        static::assertTrue($is($object));
    }

    /**
     * @test
     */
    public function testNotEquals(): void
    {
        $cb = _\notEquals('');

        static::assertTrue($cb(' '));
        static::assertTrue($cb('c'));
        static::assertTrue($cb([]));
        static::assertTrue($cb('0'));
        static::assertFalse($cb(false));
        static::assertFalse($cb(null));
    }

    /**
     * @test
     */
    public function testMatches(): void
    {
        $match = _\matches('/^x[1-9]+x$/');

        static::assertFalse($match('_0'));
        static::assertFalse($match('123456'));
        static::assertFalse($match('x123456'));
        static::assertFalse($match('123456x'));
        static::assertFalse($match('x0x'));
        static::assertTrue($match('x1x'));
    }

    /**
     * @test
     */
    public function testMatchesEmpty(): void
    {
        $match = _\matches('');

        static::assertFalse($match(''));
    }

    /**
     * @test
     */
    public function testNotMatches(): void
    {
        $notMatch = _\notMatches('/^x[1-9]+x$/');

        static::assertTrue($notMatch('_0'));
        static::assertTrue($notMatch('123456'));
        static::assertTrue($notMatch('x123456'));
        static::assertTrue($notMatch('123456x'));
        static::assertTrue($notMatch('x0x'));
        static::assertFalse($notMatch('x1x'));
    }

    /**
     * @test
     */
    public function testNotMatchesEmpty(): void
    {
        $notMatch = _\notMatches('');

        static::assertTrue($notMatch(''));
    }

    /**
     * @test
     */
    public function testMoreThan(): void
    {
        $cb = _\moreThan(8.5);

        static::assertTrue($cb(8.6));
        static::assertTrue($cb(9));
        static::assertTrue($cb(125));
        static::assertFalse($cb(8.5));
        static::assertFalse($cb(8));
        static::assertFalse($cb(-8));
    }

    /**
     * @test
     */
    public function testMoreThanOfEqual(): void
    {
        $cb = _\moreThanOrEqual(8.5);

        static::assertTrue($cb(8.6));
        static::assertTrue($cb(9));
        static::assertTrue($cb(125));
        static::assertTrue($cb(8.5));
        static::assertFalse($cb(8));
        static::assertFalse($cb(-8));
    }

    /**
     * @test
     */
    public function testLessThan(): void
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

    /**
     * @test
     */
    public function testLessThanOrEqual(): void
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

    /**
     * @test
     */
    public function testBetween(): void
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

    /**
     * @test
     */
    public function testBetweenInner(): void
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

    /**
     * @test
     */
    public function testBetweenLeft(): void
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

    /**
     * @test
     */
    public function testBetweenRight(): void
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
