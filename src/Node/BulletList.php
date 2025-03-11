<?php

declare(strict_types=1);

namespace Storyblok\TiptapBundle\Node;

use Tiptap\Nodes\BulletList as BaseBulletList;

final class BulletList extends BaseBulletList
{
    public static $name = 'bullet_list';
}
