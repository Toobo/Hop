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
use stdClass;
use Toobo\Hop as _;

class SizeTest extends TestCase
{
    /**
     * @test
     */
    public function testSize(): void
    {
        $cb = _\size(2);

        static::assertTrue($cb('ab'));
        static::assertTrue($cb(['a', 'b']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b', 'c']));
        static::assertFalse($cb(new \ArrayIterator(['a'])));
    }

    /**
     * @test
     */
    public function testSmallerThan(): void
    {
        $cb = _\smallerThan(3);

        static::assertTrue($cb('ab'));
        static::assertTrue($cb(['a', 'b']));
        static::assertTrue($cb(new \ArrayIterator(['a'])));
        static::assertFalse($cb('abc'));
        static::assertFalse($cb(['a', 'b', 'c']));
        static::assertFalse($cb(new \ArrayIterator(['a', 'b', 'c'])));
    }

    /**
     * @test
     */
    public function testSmallerThanOrEqual(): void
    {
        $cb = _\smallerThanOrEqual(3);

        static::assertTrue($cb('a'));
        static::assertTrue($cb(['a', 'b']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c'])));
        static::assertFalse($cb('a b '));
        static::assertFalse($cb(['a', 'b', 'c', 'd']));
        static::assertFalse($cb(new \ArrayIterator(['a', 'b', 'c', 'd', 'e'])));
    }

    /**
     * @test
     */
    public function testBiggerThan(): void
    {
        $cb = _\biggerThan(2);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('ac'));
        static::assertFalse($cb(['a', 'b']));
        static::assertFalse($cb(new \ArrayIterator(['a'])));
    }

    /**
     * @test
     */
    public function testBiggerThanOrEqual(): void
    {
        $cb = _\biggerThanOrEqual(3);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('ab'));
        static::assertFalse($cb(['a']));
        static::assertFalse($cb(new \ArrayIterator([])));
    }

    /**
     * @test
     */
    public function testSizeBetween(): void
    {
        $cb = _\sizeBetween(2, 4);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e']));
        static::assertFalse($cb(new \ArrayIterator([])));
    }

    /**
     * @test
     */
    public function testSizeBetweenInner(): void
    {
        $cb = _\sizeBetweenInner(2, 5);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c', 'd']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c'])));
        static::assertFalse($cb('a', 'c'));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e']));
        static::assertFalse($cb(new \ArrayIterator(['a'])));
    }

    /**
     * @test
     */
    public function testSizeBetweenLeft(): void
    {
        $cb = _\sizeBetweenLeft(2, 5);

        static::assertTrue($cb('ab'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e']));
        static::assertFalse($cb(new \ArrayIterator([])));
    }

    /**
     * @test
     */
    public function testSizeBetweenRight(): void
    {
        $cb = _\sizeBetweenRight(2, 5);

        static::assertTrue($cb('abc'));
        static::assertTrue($cb(['a', 'b', 'c', 'd']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd', 'e'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b']));
        static::assertFalse($cb(new \ArrayIterator(['a', 'b', 'c', 'd', 'e', 'f'])));
    }

    /**
     * @test
     */
    public function testSizeFailForWrongType(): void
    {
        $cb = _\size(2);

        $this->expectException(\TypeError::class);
        $cb(new stdClass());
    }
}
