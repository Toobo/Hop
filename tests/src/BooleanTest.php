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
    public function testAlways()
    {
        $cb = _\always();

        static::assertTrue($cb(true));
        static::assertTrue($cb(false));
        static::assertTrue($cb());
    }

    public function testNever()
    {
        $cb = _\never();

        static::assertFalse($cb(true));
        static::assertFalse($cb(false));
        static::assertFalse($cb());
    }

    public function testIsEmpty()
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

    public function testIsNotEmpty()
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

    public function testIsTrueish()
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

    public function testIsFalsey()
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

    public function testIsBooleanLooking()
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
