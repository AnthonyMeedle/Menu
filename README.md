# thelia-v2-module-Menu
module de création de menu - glisser déposer (drag and drop) de catégorie ou/et dossier

code d'une boucle pour afficher un menu ayant l'id 1 : 
  <pre><code>
  <ul>
  {loop type="menu_item" name="menuGeneral" menu_id=1}
    {if $TYPE && $OBJET}
      {loop type=$TYPE name="itemmenuMenuGeneral" id=$OBJET}
  		  ``<li><a href="{$URL}" title="{$CHAPO}">{$TITLE}</a></li>``
  		{/loop}
  	{/if}
  {/loop}
  </ul>
<pre><code>
