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

class ContainTest extends TestCase
{
    /**
     * @test
     */
    public function testContains(): void
    {
        $cb = _\contains('foo');

        static::assertFalse($cb('bar'));
        static::assertFalse($cb('Foo'));
        static::assertFalse($cb('f oo'));
        static::assertTrue($cb('foo'));
        static::assertTrue($cb('abcfoobar'));
        static::assertTrue($cb('abc foo bar'));
    }

    /**
     * @test
     */
    public function testHasOnArray(): void
    {
        $cb = _\has(1);

        static::assertTrue($cb([1]));
        static::assertTrue($cb([2, 1]));
        static::assertTrue($cb([2 => 1]));
        static::assertFalse($cb(['1']));
        static::assertFalse($cb([]));
        static::assertFalse($cb([11]));
    }

    /**
     * @test
     */
    public function testStartWithLetter(): void
    {
        $cb = _\startsWith('X');

        static::assertTrue($cb('X'));
        static::assertTrue($cb('X-Files'));
        static::assertTrue($cb('X,Y'));
        static::assertTrue($cb('X, Y'));
        static::assertTrue($cb('X Y'));
        static::assertFalse($cb(' X'));
        static::assertFalse($cb('x'));
        static::assertFalse($cb('ZYX'));
    }

    /**
     * @test
     */
    public function testStartWithText(): void
    {
        $cb = _\startsWith('Hi');

        static::assertTrue($cb('Hi'));
        static::assertTrue($cb('Hi '));
        static::assertTrue($cb('Hi there, how are you?'));
        static::assertTrue($cb("Hi\nthere, how are you?"));
        static::assertFalse($cb(" Hi\nthere, how are you?"));
        static::assertFalse($cb("\nHi\nthere, how are you?"));
        static::assertFalse($cb(" Hi"));
    }

    /**
     * @test
     */
    public function testEndsWithLetter(): void
    {
        $cb = _\endsWith('X');

        static::assertTrue($cb('X'));
        static::assertTrue($cb('Files-X'));
        static::assertTrue($cb('Y,X'));
        static::assertTrue($cb('Y, X'));
        static::assertTrue($cb('Y X'));
        static::assertTrue($cb('ZYX'));
        static::assertFalse($cb('X '));
        static::assertFalse($cb('x'));
        static::assertFalse($cb('xxx'));
        static::assertFalse($cb('XYZ'));
    }

    /**
     * @test
     */
    public function testEndsWithText(): void
    {
        $cb = _\endsWith('sùrè!');

        static::assertTrue($cb('works? sùrè!'));
        static::assertTrue($cb("works?\nsùrè!"));
        static::assertTrue($cb("Do\nthis\n\works?\nsùrè!"));
        static::assertTrue($cb("sùrè!"));
        static::assertFalse($cb("sure!"));
        static::assertFalse($cb("Sùrè!"));
        static::assertFalse($cb("Do\nthis\n\works?\nSùrè!"));
        static::assertFalse($cb("Do\nthis\n\works?\nsure!"));
    }

    /**
     * @test
     */
    public function testHeadIsSingleItem(): void
    {
        $cb = _\headIs('x');

        static::assertTrue($cb(['x', 'y', 'z']));
        static::assertTrue($cb(['x']));
        static::assertFalse($cb(['X']));
        static::assertFalse($cb(['y', 'x']));
    }

    /**
     * @test
     */
    public function testHeadIsMoreItems(): void
    {
        $cb = _\headIs('x', 'y');

        static::assertTrue($cb(['x', 'y', 'z']));
        static::assertTrue($cb(['x', 'y']));
        static::assertFalse($cb(['x']));
        static::assertFalse($cb(['X']));
        static::assertFalse($cb(['y', 'x']));
    }

    /**
     * @test
     */
    public function testTailIsSingleItem(): void
    {
        $cb = _\tailIs('z');

        static::assertTrue($cb(['x', 'y', 'z']));
        static::assertTrue($cb(['z']));
        static::assertFalse($cb(['Z']));
        static::assertFalse($cb(['z', 'y']));
    }

    /**
     * @test
     */
    public function testTailIsMoreItems(): void
    {
        $cb = _\tailIs('y', 'z');

        static::assertTrue($cb(range('a', 'z')));
        static::assertTrue($cb(['y', 'z']));
        static::assertFalse($cb(['y']));
        static::assertFalse($cb(['z']));
        static::assertFalse($cb(['y', 'z', 'a']));
    }

    /**
     * @test
     */
    public function testIn(): void
    {
        $cb = _\in(...range('a', 'd'));

        static::assertTrue($cb('a'));
        static::assertTrue($cb('b'));
        static::assertTrue($cb('c'));
        static::assertTrue($cb('d'));
        static::assertFalse($cb('e'));
    }

    /**
     * @test
     */
    public function testNotIn(): void
    {
        $cb = _\notIn(...range('a', 'd'));

        static::assertTrue($cb('A'));
        static::assertTrue($cb('B'));
        static::assertTrue($cb('e'));
        static::assertFalse($cb('a'));
        static::assertFalse($cb('c'));
        static::assertFalse($cb('d'));
    }

    /**
     * @test
     */
    public function testIntersect(): void
    {
        $cb = _\intersect(...range('b', 'e'));

        static::assertTrue($cb(range('b', 'e')));
        static::assertTrue($cb(['a', 'c']));
        static::assertTrue($cb(['c', 'd']));
        static::assertTrue($cb(['d', 'c']));
        static::assertTrue($cb(['a', 'b', 'c', 'd', 'e', 'f']));
        static::assertTrue($cb(['b']));
        static::assertTrue($cb(['e']));
        static::assertTrue($cb(['c', 'f']));
        static::assertFalse($cb(['g']));
        static::assertFalse($cb(['a', 'f']));
        static::assertFalse($cb(['B', 'C', 'D', 'E']));
    }

    /**
     * @test
     */
    public function testNotIntersect(): void
    {
        $cb = _\notIntersect(...range('b', 'e'));

        static::assertTrue($cb(range('B', 'E')));
        static::assertTrue($cb(['a']));
        static::assertTrue($cb(['f']));
        static::assertTrue($cb(['a', 'f']));
        static::assertFalse($cb(['c', 'd']));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e', 'f']));
        static::assertFalse($cb(['c']));
    }
}
