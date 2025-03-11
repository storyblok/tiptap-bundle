<?php

declare(strict_types=1);

namespace Storyblok\TiptapBundle\Node;

use Tiptap\Nodes\OrderedList as BaseOrderedList;

final class OrderedList extends BaseOrderedList
{
    public static $name = 'ordered_list';
}
