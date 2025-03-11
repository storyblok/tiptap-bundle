<?php

declare(strict_types=1);

use Storyblok\TiptapBundle\Extension\Storyblok;
use Tiptap\Marks\Bold;
use Tiptap\Marks\Code;
use Tiptap\Marks\Highlight;
use Tiptap\Marks\Italic;
use Tiptap\Marks\Link;
use Tiptap\Marks\Strike;
use Tiptap\Nodes\Blockquote;
use Tiptap\Nodes\Image;
use Tiptap\Nodes\Paragraph;
use Tiptap\Nodes\Text;

it('adds extensions correctly', function (): void {
    $options = [
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
            'renderer' => null,
        ],
    ];

    $storyblok = new Storyblok($options);
    $extensions = $storyblok->addExtensions();

    expect($extensions)->toHaveCount(30)
        ->and($extensions[0])->toBeInstanceOf(Image::class)
        ->and($extensions[1])->toBeInstanceOf(Text::class)
        ->and($extensions[2])->toBeInstanceOf(Paragraph::class)
        ->and($extensions[3])->toBeInstanceOf(Link::class)
        ->and($extensions[4])->toBeInstanceOf(Blockquote::class)
        ->and($extensions[5])->toBeInstanceOf(Bold::class)
        ->and($extensions[6])->toBeInstanceOf(Code::class)
        ->and($extensions[7])->toBeInstanceOf(Highlight::class)
        ->and($extensions[8])->toBeInstanceOf(Strike::class);
});

it('enables only three extensions', function (): void {
    $options = [
        'extensions' => [
            'image' => false,
            'text' => false,
            'paragraph' => true,
            'link' => false,
            'blockquote' => false,
            'bold' => true,
            'code' => false,
            'highlight' => false,
            'strike' => false,
            'subscript' => false,
            'superscript' => false,
            'textStyle' => false,
            'italic' => true,
            'underline' => false,
            'hardBreak' => false,
            'document' => false,
            'horizontalRule' => false,
            'mention' => false,
            'taskList' => false,
            'taskItem' => false,
            'table' => false,
            'tableRow' => false,
            'tableCell' => false,
            'tableHeader' => false,
            'bulletList' => false,
            'orderedList' => false,
            'listItem' => false,
            'heading' => false,
            'codeBlock' => false,
            'blok' => false,
        ],
        'blokOptions' => [
            'renderer' => null,
        ],
    ];

    $storyblok = new Storyblok($options);
    $extensions = array_values(array_filter($storyblok->addExtensions(), fn($extension): bool => $extension !== null));

    expect($extensions)->toHaveCount(3)
        ->and($extensions[0])->toBeInstanceOf(Paragraph::class)
        ->and($extensions[1])->toBeInstanceOf(Bold::class)
        ->and($extensions[2])->toBeInstanceOf(Italic::class);
});
