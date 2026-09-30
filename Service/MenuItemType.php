<?php

declare(strict_types=1);

namespace Menu\Service;

final class MenuItemType
{
    public const CATEGORY = 0;
    public const PRODUCT = 1;
    public const FOLDER = 2;
    public const CONTENT = 3;
    public const CUSTOM = 4;
    public const BRAND = 5;
    public const PAGE = 6;

    /** @return array<int, string> */
    public static function labels(): array
    {
        return [
            self::CATEGORY => 'Catégorie',
            self::PRODUCT => 'Produit',
            self::FOLDER => 'Dossier',
            self::CONTENT => 'Contenu',
            self::CUSTOM => 'Lien libre',
            self::BRAND => 'Marque',
            self::PAGE => 'Page',
        ];
    }

    public static function slug(int $type): string
    {
        return match ($type) {
            self::CATEGORY => 'category',
            self::PRODUCT => 'product',
            self::FOLDER => 'folder',
            self::CONTENT => 'content',
            self::BRAND => 'brand',
            self::PAGE => 'page',
            default => 'custom',
        };
    }
}
