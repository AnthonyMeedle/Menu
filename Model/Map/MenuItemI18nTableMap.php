<?php

namespace Menu\Model\Map;

use Menu\Model\MenuItemI18n;
use Menu\Model\MenuItemI18nQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'menu_item_i18n' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MenuItemI18nTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Menu.Model.Map.MenuItemI18nTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'menu_item_i18n';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Menu\\Model\\MenuItemI18n';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Menu.Model.MenuItemI18n';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the ID field
     */
    const ID = 'menu_item_i18n.ID';

    /**
     * the column name for the LOCALE field
     */
    const LOCALE = 'menu_item_i18n.LOCALE';

    /**
     * the column name for the TITLE field
     */
    const TITLE = 'menu_item_i18n.TITLE';

    /**
     * the column name for the DESCRIPTION field
     */
    const DESCRIPTION = 'menu_item_i18n.DESCRIPTION';

    /**
     * the column name for the CHAPO field
     */
    const CHAPO = 'menu_item_i18n.CHAPO';

    /**
     * the column name for the POSTSCRIPTUM field
     */
    const POSTSCRIPTUM = 'menu_item_i18n.POSTSCRIPTUM';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'menu_item_i18n.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'menu_item_i18n.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'menu_item_i18n.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'menu_item_i18n.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'menu_item_i18n.VERSION_CREATED_BY';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Locale', 'Title', 'Description', 'Chapo', 'Postscriptum', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'locale', 'title', 'description', 'chapo', 'postscriptum', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(MenuItemI18nTableMap::ID, MenuItemI18nTableMap::LOCALE, MenuItemI18nTableMap::TITLE, MenuItemI18nTableMap::DESCRIPTION, MenuItemI18nTableMap::CHAPO, MenuItemI18nTableMap::POSTSCRIPTUM, MenuItemI18nTableMap::CREATED_AT, MenuItemI18nTableMap::UPDATED_AT, MenuItemI18nTableMap::VERSION, MenuItemI18nTableMap::VERSION_CREATED_AT, MenuItemI18nTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'LOCALE', 'TITLE', 'DESCRIPTION', 'CHAPO', 'POSTSCRIPTUM', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'locale', 'title', 'description', 'chapo', 'postscriptum', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Locale' => 1, 'Title' => 2, 'Description' => 3, 'Chapo' => 4, 'Postscriptum' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, 'Version' => 8, 'VersionCreatedAt' => 9, 'VersionCreatedBy' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'locale' => 1, 'title' => 2, 'description' => 3, 'chapo' => 4, 'postscriptum' => 5, 'createdAt' => 6, 'updatedAt' => 7, 'version' => 8, 'versionCreatedAt' => 9, 'versionCreatedBy' => 10, ),
        self::TYPE_COLNAME       => array(MenuItemI18nTableMap::ID => 0, MenuItemI18nTableMap::LOCALE => 1, MenuItemI18nTableMap::TITLE => 2, MenuItemI18nTableMap::DESCRIPTION => 3, MenuItemI18nTableMap::CHAPO => 4, MenuItemI18nTableMap::POSTSCRIPTUM => 5, MenuItemI18nTableMap::CREATED_AT => 6, MenuItemI18nTableMap::UPDATED_AT => 7, MenuItemI18nTableMap::VERSION => 8, MenuItemI18nTableMap::VERSION_CREATED_AT => 9, MenuItemI18nTableMap::VERSION_CREATED_BY => 10, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'LOCALE' => 1, 'TITLE' => 2, 'DESCRIPTION' => 3, 'CHAPO' => 4, 'POSTSCRIPTUM' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, 'VERSION' => 8, 'VERSION_CREATED_AT' => 9, 'VERSION_CREATED_BY' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'locale' => 1, 'title' => 2, 'description' => 3, 'chapo' => 4, 'postscriptum' => 5, 'created_at' => 6, 'updated_at' => 7, 'version' => 8, 'version_created_at' => 9, 'version_created_by' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('menu_item_i18n');
        $this->setPhpName('MenuItemI18n');
        $this->setClassName('\\Menu\\Model\\MenuItemI18n');
        $this->setPackage('Menu.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('LOCALE', 'Locale', 'VARCHAR', false, 5, null);
        $this->addColumn('TITLE', 'Title', 'VARCHAR', false, 255, null);
        $this->addColumn('DESCRIPTION', 'Description', 'CLOB', false, null, null);
        $this->addColumn('CHAPO', 'Chapo', 'LONGVARCHAR', false, null, null);
        $this->addColumn('POSTSCRIPTUM', 'Postscriptum', 'LONGVARCHAR', false, null, null);
        $this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION', 'Version', 'INTEGER', false, null, 0);
        $this->addColumn('VERSION_CREATED_AT', 'VersionCreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('VERSION_CREATED_BY', 'VersionCreatedBy', 'VARCHAR', false, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('MenuItemI18nVersion', '\\Menu\\Model\\MenuItemI18nVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', ), 'CASCADE', null, 'MenuItemI18nVersions');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'true', 'log_created_by' => 'true', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to menu_item_i18n     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                MenuItemI18nVersionTableMap::clearInstancePool();
            }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? MenuItemI18nTableMap::CLASS_DEFAULT : MenuItemI18nTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (MenuItemI18n object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MenuItemI18nTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MenuItemI18nTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MenuItemI18nTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MenuItemI18nTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MenuItemI18nTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = MenuItemI18nTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MenuItemI18nTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MenuItemI18nTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(MenuItemI18nTableMap::ID);
            $criteria->addSelectColumn(MenuItemI18nTableMap::LOCALE);
            $criteria->addSelectColumn(MenuItemI18nTableMap::TITLE);
            $criteria->addSelectColumn(MenuItemI18nTableMap::DESCRIPTION);
            $criteria->addSelectColumn(MenuItemI18nTableMap::CHAPO);
            $criteria->addSelectColumn(MenuItemI18nTableMap::POSTSCRIPTUM);
            $criteria->addSelectColumn(MenuItemI18nTableMap::CREATED_AT);
            $criteria->addSelectColumn(MenuItemI18nTableMap::UPDATED_AT);
            $criteria->addSelectColumn(MenuItemI18nTableMap::VERSION);
            $criteria->addSelectColumn(MenuItemI18nTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(MenuItemI18nTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.LOCALE');
            $criteria->addSelectColumn($alias . '.TITLE');
            $criteria->addSelectColumn($alias . '.DESCRIPTION');
            $criteria->addSelectColumn($alias . '.CHAPO');
            $criteria->addSelectColumn($alias . '.POSTSCRIPTUM');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_AT');
            $criteria->addSelectColumn($alias . '.VERSION_CREATED_BY');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(MenuItemI18nTableMap::DATABASE_NAME)->getTable(MenuItemI18nTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MenuItemI18nTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MenuItemI18nTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MenuItemI18nTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a MenuItemI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or MenuItemI18n object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemI18nTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Menu\Model\MenuItemI18n) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MenuItemI18nTableMap::DATABASE_NAME);
            $criteria->add(MenuItemI18nTableMap::ID, (array) $values, Criteria::IN);
        }

        $query = MenuItemI18nQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MenuItemI18nTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MenuItemI18nTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the menu_item_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MenuItemI18nQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MenuItemI18n or Criteria object.
     *
     * @param mixed               $criteria Criteria or MenuItemI18n object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemI18nTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MenuItemI18n object
        }


        // Set the correct dbName
        $query = MenuItemI18nQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // MenuItemI18nTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MenuItemI18nTableMap::buildTableMap();
