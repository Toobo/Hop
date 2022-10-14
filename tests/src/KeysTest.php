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

class KeysTest extends TestCase
{
    /**
     * @test
     */
    public function testHasKey(): void
    {
        $cb = _\hasKey('foo');

        static::assertTrue($cb(['foo' => 'bar']));
        static::assertFalse($cb(['bar' => 'foo\'']));
    }

    /**
     * @test
     */
    public function testHasNotKey(): void
    {
        $cb = _\hasNotKey('bar');

        static::assertTrue($cb(['foo' => 'bar']));
        static::assertFalse($cb(['bar' => 'foo\'']));
    }

    /**
     * @test
     */
    public function testHasAllKeys(): void
    {
        $cb = _\hasAllKeys('a', 'b');

        static::assertTrue($cb(['a' => 1, 'b' => 2]));
        static::assertFalse($cb(['a' => 1, 'c' => 2]));
    }

    /**
     * @test
     */
    public function testHasAnyOfKeys(): void
    {
        $cb = _\hasAnyOfKeys('a', 'b');

        static::assertTrue($cb(['a' => 1, 'c' => 2]));
        static::assertFalse($cb(['c' => 1, 'd' => 2]));
    }

    /**
     * @test
     */
    public function testHasNoneOfKeys(): void
    {
        $cb = _\hasNoneOfKeys('a', 'b');

        static::assertFalse($cb(['a' => 1, 'c' => 2]));
        static::assertTrue($cb(['c' => 1, 'd' => 2]));
    }

    /**
     * @test
     */
    public function testHasNotAllKeys(): void
    {
        $cb = _\hasNotAllKeys('a', 'c');

        static::assertTrue($cb(['a' => 1, 'b' => 2]));
        static::assertFalse($cb(['a' => 1, 'c' => 2]));
    }

    /**
     * @test
     */
    public function testValueForKeyIs(): void
    {
        $cb = _\valueForKeyIs('a', 'A!');

        static::assertTrue($cb(['a' => 'A!']));
        static::assertFalse($cb(['a' => 'B!']));
        static::assertFalse($cb(['b' => 'A!']));
    }

    /**
     * @test
     */
    public function testValueForKeyIsNot(): void
    {
        $cb = _\valueForKeyIsNot('a', 'A!');

        static::assertFalse($cb(['a' => 'A!']));
        static::assertTrue($cb(['a' => 'B!']));
        static::assertTrue($cb(['b' => 'A!']));
    }

    /**
     * @test
     */
    public function testApplyOnValueForKey(): void
    {
        $cb = _\applyOnValueForKey('a', static function (string $val): bool {
            return $val === 'A!';
        });

        static::assertTrue($cb(['a' => 'A!']));
        static::assertFalse($cb(['a' => 'B!']));
        static::assertFalse($cb(['b' => 'A!']));
    }
}
