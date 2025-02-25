<?php

namespace Storyblok\TiptapBundle\Extension;

use Storyblok\TiptapBundle\Node\Blok;
use Storyblok\TiptapBundle\Node\BulletList;
use Storyblok\TiptapBundle\Node\CodeBlock;
use Storyblok\TiptapBundle\Node\Heading;
use Storyblok\TiptapBundle\Node\ListItem;
use Storyblok\TiptapBundle\Node\OrderedList;
use Tiptap\Core\Extension;
use Tiptap\Marks\Bold;
use Tiptap\Marks\Italic;
use Tiptap\Marks\Link;
use Tiptap\Marks\Underline;
use Tiptap\Nodes\Blockquote;
use Tiptap\Nodes\HardBreak;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Paragraph;
use Tiptap\Nodes\Text;

final class Storyblok extends Extension
{
    public function __construct(array $options = [])
    {
        $default_options = $this->addOptions();
        $this->options = [
            'extensions' => array_merge($default_options['extensions'], $options['extensions'] ?? []),
            'blokOptions' => array_merge($default_options['blokOptions'], $options['blokOptions'] ?? []),
        ];
    }

    public function addOptions()
    {
        return [
            'extensions' => [
                'image' => true,
                'text' => true,
                'paragraph' => true,
                'link' => true,
                'blockquote' => true,
                'bold' => true,
                'italic' => true,
                'underline' => true,
                'hardBreak' => true,
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
        ];
    }

    public function addExtensions()
    {
        return array_filter([
            $this->options['extensions']['image'] ? new Image() : null,
            $this->options['extensions']['text'] ? new Text() : null,
            $this->options['extensions']['paragraph'] ? new Paragraph() : null,
            $this->options['extensions']['link'] ? new Link() : null,
            $this->options['extensions']['blockquote'] ? new Blockquote() : null,
            $this->options['extensions']['bold'] ? new Bold() : null,
            $this->options['extensions']['italic'] ? new Italic() : null,
            $this->options['extensions']['underline'] ? new Underline() : null,
            $this->options['extensions']['hardBreak'] ? new HardBreak() : null,
            $this->options['extensions']['bulletList'] ? new BulletList() : null,
            $this->options['extensions']['orderedList'] ? new OrderedList() : null,
            $this->options['extensions']['listItem'] ? new ListItem() : null,
            $this->options['extensions']['heading'] ? new Heading() : null,
            $this->options['extensions']['codeBlock'] ? new CodeBlock() : null,
            $this->options['extensions']['blok'] ? new Blok([
                'renderer' => $this->options['blokOptions']['renderer']
            ]) : null,
        ]);
    }
}
