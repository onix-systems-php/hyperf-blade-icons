<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfIcons;

use OnixSystemsPHP\HyperfIcons\Contract\IconFinderInterface;
use OnixSystemsPHP\HyperfIcons\Finder\IconFinder;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                IconFinderInterface::class => IconFinder::class,
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'commands' => [],
            'listeners' => [],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config from onix-systems-php/hyperf-blade-icons.',
                    'source' => __DIR__ . '/../publish/blade-icons.php',
                    'destination' => BASE_PATH . '/config/autoload/blade-icons.php',
                ],
                [
                    'id' => 'fontawesome_svgs',
                    'description' => 'The SVGs from onix-systems-php/hyperf-blade-icons.',
                    'source' => __DIR__ . '/../publish/fontawesome',
                    'destination' => BASE_PATH . '/storage/icons/fontawesome',
                ],
            ],
        ];
    }
}
