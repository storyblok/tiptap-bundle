<?php

declare(strict_types=1);

namespace Storyblok\TiptapBundle\Node;

use Tiptap\Nodes\CodeBlock as BaseCodeBlock;

final class CodeBlock extends BaseCodeBlock
{
    public static $name = 'code_block';
}
