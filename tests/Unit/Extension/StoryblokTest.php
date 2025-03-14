<?php

declare(strict_types=1);

/**
 * This file is part of Storyblok-Api.
 *
 * (c) SensioLabs Deutschland <info@sensiolabs.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Storyblok\TiptapBundle\Tests\Unit\Extension;

use PHPUnit\Framework\TestCase;
use Storyblok\TiptapBundle\Extension\Storyblok;
use Storyblok\TiptapBundle\Node\Blok;
use Storyblok\TiptapBundle\Node\BulletList;
use Storyblok\TiptapBundle\Node\CodeBlock;
use Storyblok\TiptapBundle\Node\Heading;
use Storyblok\TiptapBundle\Node\ListItem;
use Storyblok\TiptapBundle\Node\OrderedList;
use Tiptap\Marks\Bold;
use Tiptap\Marks\Code;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Italic;
use Tiptap\Marks\Link;
use Tiptap\Marks\Strike;
use Tiptap\Marks\Subscript;
use Tiptap\Marks\Superscript;
use Tiptap\Marks\TextStyle;
use Tiptap\Marks\Underline;
use Tiptap\Nodes\Blockquote;
use Tiptap\Nodes\Document;
use Tiptap\Nodes\HardBreak;
use Tiptap\Nodes\HorizontalRule;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Mention;
use Tiptap\Nodes\Paragraph;
use Tiptap\Nodes\Table;
use Tiptap\Nodes\TableCell;
use Tiptap\Nodes\TableHeader;
use Tiptap\Nodes\TableRow;
use Tiptap\Nodes\TaskItem;
use Tiptap\Nodes\TaskList;
use Tiptap\Nodes\Text;

final class StoryblokTest extends TestCase
{
    /**
     * @test
     */
    public function addOptions(): void
    {
        $this->assertSame(
            [
                'extensions' => [
                    'image' => true,
                    'text' => true,
                    'paragraph' => true,
                    'link' => true,
                    'blockquote' => true,
                    'bold' => true,
                    'code' => true,
                    'highlight' => true,
                    'strike' => true,
                    'subscript' => true,
                    'superscript' => true,
                    'textStyle' => true,
                    'italic' => true,
                    'underline' => true,
                    'hardBreak' => true,
                    'document' => true,
                    'horizontalRule' => true,
                    'mention' => true,
                    'taskList' => true,
                    'taskItem' => true,
                    'table' => true,
                    'tableRow' => true,
                    'tableCell' => true,
                    'tableHeader' => true,
                    'bulletList' => true,
                    'orderedList' => true,
                    'listItem' => true,
                    'heading' => true,
                    'codeBlock' => true,
                    'blok' => true,
                ],
                'blokOptions' => [
                    'renderer' => null, // The user must provide a renderer function
                ],
            ],
            (new Storyblok())->addOptions(),
        );
    }

    /**
     * @test
     */
    public function addExtensions(): void
    {
        $this->assertEquals(
            [
                new Image(),
                new Text(),
                new Paragraph(),
                new Link(),
                new Blockquote(),
                new Bold(),
                new Code(),
                new Highlight(),
                new Strike(),
                new Subscript(),
                new Superscript(),
                new TextStyle(),
                new Italic(),
                new Underline(),
                new Document(),
                new HorizontalRule(),
                new Mention(),
                new TaskList(),
                new TaskItem(),
                new HardBreak(),
                new Table(),
                new TableRow(),
                new TableCell(),
                new TableHeader(),
                new BulletList(),
                new OrderedList(),
                new ListItem(),
                new Heading(),
                new CodeBlock(),
                new Blok(),
            ],
            (new Storyblok())->addExtensions(),
        );
    }
}
