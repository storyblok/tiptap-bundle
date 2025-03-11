<h1>Storyblok Tiptap Bundle</h1>

This bundle provides Tiptap extensions for [Storyblok](https://www.storyblok.com/) integration in Symfony applications.

| Branch | PHP                                                                                                                                                                   | Code Coverage                                                                                                               |
|--------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------|
| `main` | [![PHP](https://github.com/storyblok/tiptap-bundle/actions/workflows/php.yml/badge.svg)](https://github.com/storyblok/tiptap-bundle/actions/workflows/php.yml) | [![codecov](https://codecov.io/gh/storyblok/tiptap-bundle/graph/badge.svg)](https://codecov.io/gh/storyblok/tiptap-bundle) |

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
composer require storyblok/tiptap-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require storyblok/tiptap-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Storyblok\TiptapBundle\StoryblokTiptapBundle::class => ['all' => true],
];
```

## Example usage

You can follow this step-by-step guide to render the Richtext field that you have on your Storyblok blocks
in your Symfony application.

It's important to understand that this is just an example and you can customize
it to fit your needs, and it's based on the official Storyblok Symfony Bundle, and Twig,
which might not be the templating engine you are using.

Say you have a controller that fetches the data from Storyblok and passes it to the template:

```php
namespace App\Controller;

use Storyblok\Api\StoriesApi;
use Storyblok\Api\StoryblokClient;
use Storyblok\TiptapBundle\Value\RichText;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    public function __construct(
        private readonly StoryblokClient $client
    ) {}

    #[Route('/test')]
    public function index()
    {
        $storyApi = new StoriesApi($this->client, 'draft');
        $story = $storyApi->bySlug('test');

        $richtextContent = $story->story['content']['body'][0]['text'];
        $richText = new RichText($richtextContent);

        return $this->render('page.html.twig', [
            'page' => [
                'title' => $story->story['content']['body'][0]['headline'],
                'richtext' => $richText,
            ]
        ]);
    }
}
```

The `RichText` class is a simple class that you can use to handle the RichText field from the API:

```php
<?php

namespace App\Bridge\Storyblok\Value\Type;

final class RichText
{
    /**
     * @var array<string, mixed>
     */
    private readonly array $content;

    /**
     * @param array<string, mixed>|string|null $content
     */
    public function __construct(array|string|null $content = null)
    {
        if (null === $content) {
            $this->content = [];
            return;
        }

        if (is_string($content)) {
            $this->content = json_decode($content, true) ?? [];
            return;
        }

        $this->content = $content;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->content;
    }
}
```

Then you should create an `Extension` for Twig to render the RichText field.

Here we are using the official Tiptap Editor, and we provide our custom extension just by passing `new Storyblok()`
to the `extensions` option of the `Editor`.

This is the core of the integration: here we are defining the filters `render_block` and `render_text` that will render the blocks and the text respectively.

Notice that `render_block` is called from `render_text` to render the blocks inside the RichText field, a feature
that Storyblok allows you to do. You can customize this to fit your needs, providing a custom renderer for each block type.

But it's **mandatory** to provide a renderer for the blocks, otherwise, the Bundle will raise an exception.

You can see the `renderer` function provided in the `blockOptions` array.

The other option is `extensions` that you can pass to the `Storyblok` extension to disable some of the default extensions.
This will allow you to use your own custom extensions, or to add third-party extensions.

The complete list of extensions (all enabled by default) is:

```php
[
    // Base Tiptap extensions
    'image' => true,
    'text' => true,
    'paragraph' => true,
    'link' => true,
    'blockquote' => true,
    'bold' => true,
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
    
    // Storyblok extensions
    'bulletList' => true,
    'orderedList' => true,
    'listItem' => true,
    'heading' => true,
    'codeBlock' => true,
    'blok' => true,
]
```

This is the complete source code for reference:

```php
<?php

namespace App\Twig\Extension;

use App\Bridge\Storyblok\Builder\BlockBuilder;
use App\Bridge\Storyblok\Value\Block\BlockInterface;
use App\Bridge\Storyblok\Value\Type\RichText;
use Storyblok\TiptapBundle\Extension\Storyblok;
use Tiptap\Editor;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use function Symfony\Component\String\u;

final class BlockExtension extends AbstractExtension
{
    /**
     * @return list<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('render_block', $this->renderBlock(...), ['is_safe' => ['html'], 'needs_environment' => true]),
            new TwigFilter('render_text', $this->renderText(...), ['is_safe' => ['html'], 'needs_environment' => true]),
        ];
    }

    public function renderBlock(Environment $twig, BlockInterface $block): string
    {
        $template = u($block::class)->afterLast('\\')->toString();

        return $twig->render(
            \sprintf('blocks/%s.html.twig', $template),
            ['block' => $block],
        );
    }

    public function renderText(Environment $twig, RichText $text): string
    {
        $editor = new Editor([
            'extensions' => [
                new Storyblok([
                    'extensions' => [
                        // Set which extension you want to disable, e.g.:
                        // 'codeBlock' => false,
                    ],
                    'blokOptions' => [
                        'renderer' => fn(array $value): string => $this->renderBlock($twig, BlockBuilder::create($value)),
                    ]
                ]),
            ],
        ]);

        $editor->setContent($text->toArray());

        return $editor->getHTML();
    }
}
```

And then in your template, you can render the RichText field like this:

```twig
{# templates/page.html.twig #}
<h1>{{ page.title }}</h1>
<div class="rich-text">
    {{ page.richtext|render_text }}
</div>
```

In our code we used a `BlockBuilder` class to create the blocks and provide the corresponding Twig template for each block type:

```twig
{# templates/blocks/Teaser.html.twig #}
<div class="teaser">
    {% if block.image %}
        <img src="{{ block.image }}" alt="{{ block.title }}">
    {% endif %}
    <h3>{{ block.headline }}</h3>
</div>
```

You can find more information on how to render blocks in Symfony in the [official Storyblok Symfony Bundle](https://github.com/storyblok/symfony-bundle).

## License

This bundle is under the MIT license. See the complete license in the [LICENSE](LICENSE) file.

## Acknowledgments

This bundle is based on the [Tiptap](https://tiptap.dev/) editor and on the official [Tiptap for PHP](https://github.com/ueberdosis/tiptap-php/) library.

Thanks to [SensioLabs](https://sensiolabs.com/) for the help with the initial implementation of the bundle.
