<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfIcons\Finder;

use Hyperf\Collection\Collection;
use Hyperf\Stringable\Str;
use OnixSystemsPHP\HyperfIcons\Contract\IconFinderInterface;

use function Hyperf\Collection\collect;
use function Hyperf\Config\config;

class IconFinder implements IconFinderInterface
{
    private Collection $directories;

    private string $width = '1em';

    private string $height = '1em';

    /**
     * IconFinder constructor.
     */
    public function __construct()
    {
        $this->directories = collect();
        foreach (config('blade-icons.icons') as $prefix => $directory) {
            $this->registerIconDirectory($prefix, $directory);
        }
    }

    public function registerIconDirectory(string $prefix, string $directory): self
    {
        $this->directories = $this->directories->merge([
            $prefix => $directory,
        ]);

        return $this;
    }

    public function loadFile(string $name): ?string
    {
        $prefix = Str::of($name)->before('.')->toString();
        $dir = (string) $this->directories->get($prefix);

        if ($dir !== '') {
            return $this->getContent($name, $prefix, $dir);
        }

        // Failed to find the icon
        return $this->directories
            ->map(fn ($dir) => $this->getContent($name, $prefix, $dir))
            ->filter()
            ->first();
    }

    /**
     * @return $this
     */
    public function setSize(string $width = '1em', string $height = '1em'): IconFinder
    {
        $this->width = $width;
        $this->height = $height;

        return $this;
    }

    /**
     * Return the default width.
     */
    public function getDefaultWidth(): string
    {
        return $this->width;
    }

    /**
     * Return the default height.
     */
    public function getDefaultHeight(): string
    {
        return $this->height;
    }

    protected function getContent(string $name, string $prefix, string $dir): ?string
    {
        $file = Str::of($name)
            ->when($prefix !== $name, fn ($string) => $string->replaceFirst($prefix, ''))
            ->replaceFirst('.', '')
            ->replace('.', '/');

        $path = $dir . '/' . $file . '.svg';

        try {
            $file = file_get_contents($path);
            return $file ?: null;
        } catch (\Exception) {
            return null;
        }
    }
}
