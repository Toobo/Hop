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

class BooleanTest extends TestCase
{
    /**
     * @test
     */
    public function testAlways(): void
    {
        $cb = _\always();

        static::assertTrue($cb(true));
        static::assertTrue($cb(false));
        static::assertTrue($cb());
    }

    /**
     * @test
     */
    public function testNever(): void
    {
        $cb = _\never();

        static::assertFalse($cb(true));
        static::assertFalse($cb(false));
        static::assertFalse($cb());
    }

    /**
     * @test
     */
    public function testIsEmpty(): void
    {
        $cb = _\isEmpty();

        static::assertTrue($cb(false));
        static::assertTrue($cb(null));
        static::assertTrue($cb(''));
        static::assertTrue($cb([]));
        static::assertTrue($cb(0));
        static::assertTrue($cb(0.0));
        static::assertFalse($cb('0'));
        static::assertFalse($cb(' '));
        static::assertFalse($cb(new \stdClass()));
    }

    /**
     * @test
     */
    public function testIsNotEmpty(): void
    {
        $cb = _\isNotEmpty();

        static::assertFalse($cb(false));
        static::assertFalse($cb(null));
        static::assertFalse($cb(''));
        static::assertFalse($cb([]));
        static::assertFalse($cb(0));
        static::assertFalse($cb(0.0));
        static::assertTrue($cb('0'));
        static::assertTrue($cb(' '));
        static::assertTrue($cb(new \stdClass()));
    }

    /**
     * @test
     */
    public function testIsTrueish(): void
    {
        $cb = _\isTrueish();

        static::assertTrue($cb(1));
        static::assertTrue($cb(true));
        static::assertTrue($cb('on'));
        static::assertTrue($cb('yes'));
        static::assertTrue($cb('true'));
        static::assertFalse($cb(0));
        static::assertFalse($cb(false));
        static::assertFalse($cb('off'));
        static::assertFalse($cb('false'));
        static::assertFalse($cb('meh'));
        static::assertFalse($cb([true]));
        static::assertFalse($cb(null));
    }

    /**
     * @test
     */
    public function testIsFalsey(): void
    {
        $cb = _\isFalsey();

        static::assertTrue($cb(0));
        static::assertTrue($cb(false));
        static::assertTrue($cb('off'));
        static::assertTrue($cb('false'));
        static::assertFalse($cb(1));
        static::assertFalse($cb(true));
        static::assertFalse($cb('on'));
        static::assertFalse($cb('yes'));
        static::assertFalse($cb('true'));
        static::assertFalse($cb('meh'));
        static::assertFalse($cb([]));
        static::assertFalse($cb(null));
    }

    /**
     * @test
     */
    public function testIsBooleanLooking(): void
    {
        $cb = _\isBooleanLooking();

        static::assertTrue($cb(0));
        static::assertTrue($cb(false));
        static::assertTrue($cb('off'));
        static::assertTrue($cb('false'));
        static::assertTrue($cb(1));
        static::assertTrue($cb(true));
        static::assertTrue($cb('on'));
        static::assertTrue($cb('yes'));
        static::assertTrue($cb('true'));
        static::assertFalse($cb('meh'));
        static::assertFalse($cb([]));
        static::assertFalse($cb(null));
    }
}
