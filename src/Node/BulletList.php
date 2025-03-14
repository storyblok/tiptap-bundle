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

namespace Storyblok\TiptapBundle\Node;

use Tiptap\Nodes\BulletList as BaseBulletList;

final class BulletList extends BaseBulletList
{
    public static $name = 'bullet_list';
}
