<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok PHP Tiptap Extension.
 *
 * (c) SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\TiptapBundle\Node;

use Tiptap\Nodes\CodeBlock as BaseCodeBlock;

final class CodeBlock extends BaseCodeBlock
{
    public static $name = 'code_block';
}
