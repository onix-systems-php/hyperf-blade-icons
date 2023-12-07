<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfIcons\Contract;

use OnixSystemsPHP\HyperfIcons\Finder\IconFinder;

interface IconFinderInterface
{
    public function registerIconDirectory(string $prefix, string $directory): self;

    public function loadFile(string $name): ?string;

    public function setSize(string $width = '1em', string $height = '1em'): IconFinder;

    public function getDefaultWidth(): string;

    public function getDefaultHeight(): string;
}
