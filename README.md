# Menu pour Thelia 3

Réécriture du module historique `AnthonyMeedle/Menu` pour Thelia 3.

## Fonctionnalités

- administration Twig / Bootstrap 5 avec formulaires CSRF ;
- plusieurs menus activables indépendamment ;
- hiérarchie sans limite pratique : élément principal, sous-item, sous-sous-item ;
- déplacement accessible par les actions monter, descendre, indenter et remonter ;
- destinations : catégorie, produit, dossier, contenu, marque, page et lien libre ;
- sélection rapide conservée lorsque le site contient au plus 150 destinations ;
- explorateur chargé à la demande pour les gros catalogues, avec recherche et sections Catalogue, Dossiers, Marques et Pages ;
- actions distinctes « Parcourir » et « Choisir » sur les catégories, dossiers et pages ;
- surcharge du titre, de l'URL, du texte court, de l'icône et de la classe CSS ;
- compatibilité des tables et des boucles `menu` / `menu_item` de l'ancien module.

## Utilisation dans un thème

```smarty
<ul>
{loop type="menu_item" name="main-menu" menu=1 parent=0}
    <li class="{$CSS_CLASS}{$ACTIVE}">
        <a href="{$URL}"{$TARGET}>{$TITLE}</a>
        {if $HAS_CHILDREN}
            <ul>
            {loop type="menu_item" name="submenu-{$MENU_ITEM_ID}" menu=$MENU_ID parent=$MENU_ITEM_ID}
                <li><a href="{$URL}"{$TARGET}>{$TITLE}</a></li>
            {/loop}
            </ul>
        {/if}
    </li>
{/loop}
</ul>
```

`ID` reste l'identifiant de l'objet cible pour préserver la compatibilité. Utiliser
`MENU_ITEM_ID` pour identifier de façon certaine une entrée du menu.
