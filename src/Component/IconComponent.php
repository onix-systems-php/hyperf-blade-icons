<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfIcons\Component;

use Hyperf\Collection\Collection;
use Hyperf\ViewEngine\Component\Component;
use OnixSystemsPHP\HyperfIcons\Contract\IconFinderInterface;

use function Hyperf\Collection\collect;

class IconComponent extends Component
{
    public function __construct(
        public string $path,
        private readonly IconFinderInterface $finder,
        public ?string $id = null,
        public ?string $class = null,
        public ?string $width = null,
        public ?string $height = null,
        public string $role = 'img',
        public string $fill = 'currentColor',
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): callable
    {
        return fn () => $this->renderIcon();
    }

    protected function iconsAttributes(): Collection
    {
        return collect($this->extractPublicProperties())
            ->except(['attributes'])
            ->merge($this->attributes?->getAttributes())
            ->filter(static fn ($value) => is_string($value));
    }

    private function renderIcon(): string
    {
        $this->width = $this->width ?? $this->finder->getDefaultWidth();
        $this->height = $this->height ?? $this->finder->getDefaultHeight();

        $icon = $this->finder->loadFile($this->path);

        return $this->setAttributes($icon);
    }

    private function setAttributes(?string $icon): string
    {
        if ($icon === null) {
            return '';
        }

        $dom = new \DOMDocument();
        $dom->loadXML($icon);

        /** @var \DOMElement $item */
        $item = $dom->getElementsByTagName('svg')->item(0);

        if ($item !== null) {
            $this
                ->iconsAttributes()
                ->each(static fn (string $value, string $key) => $item->setAttribute($key, $value));
        }

        return $dom->saveHTML();
    }
}
