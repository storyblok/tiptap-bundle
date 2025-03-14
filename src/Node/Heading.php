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

namespace Storyblok\Tiptap\Node;

use Tiptap\Nodes\Heading as BaseHeading;

final class Heading extends BaseHeading
{
    /**
     * @return array<string, mixed>
     */
    public function addAttributes(): array
    {
        return [
            'id' => [
                'renderHTML' => static fn ($attributes): array => ['id' => $attributes->id ?? null],
            ],
        ];
    }
}
