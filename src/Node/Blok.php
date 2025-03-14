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

use Safe\Exceptions\JsonException;
use Storyblok\Tiptap\Exception\InvalidConfigurationException;
use Tiptap\Core\Node;
use function Safe\json_decode;
use function Safe\json_encode;

final class Blok extends Node
{
    public static $name = 'blok';

    /**
     * @return array<string, null>
     */
    public function addOptions(): array
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
        if (!\is_callable($this->options['renderer'])) {
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
