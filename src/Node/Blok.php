<?php

declare(strict_types=1);

namespace Storyblok\TiptapBundle\Node;

use Safe\Exceptions\JsonException;
use Storyblok\TiptapBundle\Exception\InvalidConfigurationException;
use Tiptap\Core\Node;

use function Safe\json_decode;
use function Safe\json_encode;

final class Blok extends Node
{
    public static $name = 'blok';

    public function addOptions()
    {
        return [
            'renderer' => null,
        ];
    }

    /**
     * @param array<string, mixed> $HTMLAttributes
     *
     * @return array<string, mixed>
     */
    public function renderHTML(mixed $node, array $HTMLAttributes = []): array
    {
        if (!is_callable($this->options['renderer'])) {
            throw new InvalidConfigurationException(
                'You must provide a renderer function for the Blok extension',
            );
        }

        $values = $node->attrs?->body ?? [];

        if ([] === $values) {
            return [];
        }

        $content = '';

        foreach ($values as $value) {
            try {
                $content .= ($this->options['renderer'])(json_decode(json_encode($value), true));
            } catch (JsonException) {
                throw new InvalidConfigurationException(
                    'Could not render the Blok extension',
                );
            }
        }

        return [
            'content' => $content,
        ];
    }
}
