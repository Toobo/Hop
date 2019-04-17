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

    public function testSize()
    {
        $cb = _\size(2);

        static::assertTrue($cb('ab'));
        static::assertTrue($cb(['a', 'b']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b', 'c']));
        static::assertFalse($cb(new \ArrayIterator(['a'])));
    }

    public function testSmallerThan()
    {
        $cb = _\smallerThan(3);

        static::assertTrue($cb('ab'));
        static::assertTrue($cb(['a', 'b']));
        static::assertTrue($cb(new \ArrayIterator(['a'])));
        static::assertFalse($cb('abc'));
        static::assertFalse($cb(['a', 'b', 'c']));
        static::assertFalse($cb(new \ArrayIterator(['a', 'b', 'c'])));
    }

    public function testSmallerThanOrEqual()
    {
        $cb = _\smallerThanOrEqual(3);

        static::assertTrue($cb('a'));
        static::assertTrue($cb(['a', 'b']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c'])));
        static::assertFalse($cb('a b '));
        static::assertFalse($cb(['a', 'b', 'c', 'd']));
        static::assertFalse($cb(new \ArrayIterator(['a', 'b', 'c', 'd', 'e'])));
    }

    public function testBiggerThan()
    {
        $cb = _\biggerThan(2);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('ac'));
        static::assertFalse($cb(['a', 'b']));
        static::assertFalse($cb(new \ArrayIterator(['a'])));
    }

    public function testBiggerThanOrEqual()
    {
        $cb = _\biggerThanOrEqual(3);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('ab'));
        static::assertFalse($cb(['a']));
        static::assertFalse($cb(new \ArrayIterator([])));
    }

    public function testSizeBetween()
    {
        $cb = _\sizeBetween(2, 4);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e']));
        static::assertFalse($cb(new \ArrayIterator([])));
    }

    public function testSizeBetweenInner()
    {
        $cb = _\sizeBetweenInner(2, 5);

        static::assertTrue($cb('a b'));
        static::assertTrue($cb(['a', 'b', 'c', 'd']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c'])));
        static::assertFalse($cb('a', 'c'));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e']));
        static::assertFalse($cb(new \ArrayIterator(['a'])));
    }

    public function testSizeBetweenLeft()
    {
        $cb = _\sizeBetweenLeft(2, 5);

        static::assertTrue($cb('ab'));
        static::assertTrue($cb(['a', 'b', 'c']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b', 'c', 'd', 'e']));
        static::assertFalse($cb(new \ArrayIterator([])));
    }

    public function testSizeBetweenRight()
    {
        $cb = _\sizeBetweenRight(2, 5);

        static::assertTrue($cb('abc'));
        static::assertTrue($cb(['a', 'b', 'c', 'd']));
        static::assertTrue($cb(new \ArrayIterator(['a', 'b', 'c', 'd', 'e'])));
        static::assertFalse($cb('a'));
        static::assertFalse($cb(['a', 'b']));
        static::assertFalse($cb(new \ArrayIterator(['a', 'b', 'c', 'd', 'e', 'f'])));
    }

    public function testSizeFailForWrongType()
    {
        $cb = _\size(2);

        $this->expectException(\TypeError::class);
        $cb(new stdClass());
    }
}
