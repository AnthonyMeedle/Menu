# thelia-v2-module-Menu
module de création de menu - glisser déposer (drag and drop) de catégorie ou/et dossier

## Loop

### MenuItemLoop - menu_item

### Input arguments

|Argument           |Description                                                |
|---                |---                                                        |
|**id**             | filter by id                                              |
|**menu**           | filter by menu_id                                         |
|**menu_id**     	| filter by menu_id                                         |
|**active**         | name class add in current item (default : active)			|


### Output arguments

|Variable       |Description                										|
|---            |---                        										|
|$ID            | id objet (category_id or product_id or folder_id or content_id) 	|
|$MENU_ID      	| Parent id (menu_id) 			            						|
|$MENU_ITEM_ID  | menu item id 			            								|
|$OBJET   		| id objet (category_id or product_id or folder_id or content_id)   |
|$TYPE   		| category or product or folder or content        					|
|$TYPE_ID   	| 0 or 1 or 2 or 3        											|
|$TITLE   		| Item title        												|
|$CHAPO   		| Item chapo        												|
|$DESCRIPTION   | Item description        											|
|$POSTSCRIPTUM  | Item postscriptum     	    									|
|$URL   		| Item url        													|
|$ACTIVE   		| add class if current item or parent of current item        		|


code d'une boucle pour afficher un menu ayant l'id 1 : 
  <pre><code>
  &lt;ul&gt;
  {loop type="menu_item" name="menuGeneral" menu_id=1}
	  &lt;li&gt;&lt;a href="{$URL}" title="{$CHAPO}" class="{$ACTIVE}"&gt;{$TITLE}&lt;/a&gt;&lt;/li&gt;
  {/loop}
  &lt;/ul&gt;
<pre><code>
