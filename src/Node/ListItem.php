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

use Tiptap\Nodes\ListItem as BaseListItem;

final class ListItem extends BaseListItem
{
    public static $name = 'list_item';
}
