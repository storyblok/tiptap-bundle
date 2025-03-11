<?php

declare(strict_types=1);

namespace Storyblok\TiptapBundle\Node;

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
                'renderHTML' => static fn($attributes): array => ['id' => $attributes->id ?? null],
            ],
        ];
    }
}
