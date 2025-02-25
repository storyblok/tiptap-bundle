<?php

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
                'renderHTML' => static fn ($attributes) => ['id' => $attributes->id ?? null],
            ],
        ];
    }
}