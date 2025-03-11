<?php

declare(strict_types=1);

namespace Storyblok\TiptapBundle\Node;

use Tiptap\Nodes\ListItem as BaseListItem;

final class ListItem extends BaseListItem
{
    public static $name = 'list_item';
}
