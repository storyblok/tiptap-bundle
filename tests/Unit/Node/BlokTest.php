<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok PHP Tiptap Extension.
 *
 * (c) Storyblok GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\TiptapBundle\Tests\Unit\Node;

use PHPUnit\Framework\TestCase;
use Storyblok\TiptapBundle\Node\Blok;

final class BlokTest extends TestCase
{
    /**
     * @test
     */
    public function name(): void
    {
        self::assertSame('blok', (new Blok())::$name);
    }

    /**
     * @test
     */
    public function addOptions(): void
    {
        self::assertSame([
            'renderer' => null,
        ], (new Blok())->addOptions());
    }
}
