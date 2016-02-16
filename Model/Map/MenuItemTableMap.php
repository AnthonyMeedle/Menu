<?php

namespace Menu\Model\Map;

use Menu\Model\MenuItem;
use Menu\Model\MenuItemQuery;
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
 * This class defines the structure of the 'menu_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MenuItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Menu.Model.Map.MenuItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'thelia';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'menu_item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Menu\\Model\\MenuItem';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Menu.Model.MenuItem';

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
    const ID = 'menu_item.ID';

    /**
     * the column name for the MENU_ID field
     */
    const MENU_ID = 'menu_item.MENU_ID';

    /**
     * the column name for the VISIBLE field
     */
    const VISIBLE = 'menu_item.VISIBLE';

    /**
     * the column name for the POSITION field
     */
    const POSITION = 'menu_item.POSITION';

    /**
     * the column name for the TYPOBJ field
     */
    const TYPOBJ = 'menu_item.TYPOBJ';

    /**
     * the column name for the OBJET field
     */
    const OBJET = 'menu_item.OBJET';

    /**
     * the column name for the CREATED_AT field
     */
    const CREATED_AT = 'menu_item.CREATED_AT';

    /**
     * the column name for the UPDATED_AT field
     */
    const UPDATED_AT = 'menu_item.UPDATED_AT';

    /**
     * the column name for the VERSION field
     */
    const VERSION = 'menu_item.VERSION';

    /**
     * the column name for the VERSION_CREATED_AT field
     */
    const VERSION_CREATED_AT = 'menu_item.VERSION_CREATED_AT';

    /**
     * the column name for the VERSION_CREATED_BY field
     */
    const VERSION_CREATED_BY = 'menu_item.VERSION_CREATED_BY';

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
        self::TYPE_PHPNAME       => array('Id', 'MenuId', 'Visible', 'Position', 'Typobj', 'Objet', 'CreatedAt', 'UpdatedAt', 'Version', 'VersionCreatedAt', 'VersionCreatedBy', ),
        self::TYPE_STUDLYPHPNAME => array('id', 'menuId', 'visible', 'position', 'typobj', 'objet', 'createdAt', 'updatedAt', 'version', 'versionCreatedAt', 'versionCreatedBy', ),
        self::TYPE_COLNAME       => array(MenuItemTableMap::ID, MenuItemTableMap::MENU_ID, MenuItemTableMap::VISIBLE, MenuItemTableMap::POSITION, MenuItemTableMap::TYPOBJ, MenuItemTableMap::OBJET, MenuItemTableMap::CREATED_AT, MenuItemTableMap::UPDATED_AT, MenuItemTableMap::VERSION, MenuItemTableMap::VERSION_CREATED_AT, MenuItemTableMap::VERSION_CREATED_BY, ),
        self::TYPE_RAW_COLNAME   => array('ID', 'MENU_ID', 'VISIBLE', 'POSITION', 'TYPOBJ', 'OBJET', 'CREATED_AT', 'UPDATED_AT', 'VERSION', 'VERSION_CREATED_AT', 'VERSION_CREATED_BY', ),
        self::TYPE_FIELDNAME     => array('id', 'menu_id', 'visible', 'position', 'typobj', 'objet', 'created_at', 'updated_at', 'version', 'version_created_at', 'version_created_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'MenuId' => 1, 'Visible' => 2, 'Position' => 3, 'Typobj' => 4, 'Objet' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, 'Version' => 8, 'VersionCreatedAt' => 9, 'VersionCreatedBy' => 10, ),
        self::TYPE_STUDLYPHPNAME => array('id' => 0, 'menuId' => 1, 'visible' => 2, 'position' => 3, 'typobj' => 4, 'objet' => 5, 'createdAt' => 6, 'updatedAt' => 7, 'version' => 8, 'versionCreatedAt' => 9, 'versionCreatedBy' => 10, ),
        self::TYPE_COLNAME       => array(MenuItemTableMap::ID => 0, MenuItemTableMap::MENU_ID => 1, MenuItemTableMap::VISIBLE => 2, MenuItemTableMap::POSITION => 3, MenuItemTableMap::TYPOBJ => 4, MenuItemTableMap::OBJET => 5, MenuItemTableMap::CREATED_AT => 6, MenuItemTableMap::UPDATED_AT => 7, MenuItemTableMap::VERSION => 8, MenuItemTableMap::VERSION_CREATED_AT => 9, MenuItemTableMap::VERSION_CREATED_BY => 10, ),
        self::TYPE_RAW_COLNAME   => array('ID' => 0, 'MENU_ID' => 1, 'VISIBLE' => 2, 'POSITION' => 3, 'TYPOBJ' => 4, 'OBJET' => 5, 'CREATED_AT' => 6, 'UPDATED_AT' => 7, 'VERSION' => 8, 'VERSION_CREATED_AT' => 9, 'VERSION_CREATED_BY' => 10, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'menu_id' => 1, 'visible' => 2, 'position' => 3, 'typobj' => 4, 'objet' => 5, 'created_at' => 6, 'updated_at' => 7, 'version' => 8, 'version_created_at' => 9, 'version_created_by' => 10, ),
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
        $this->setName('menu_item');
        $this->setPhpName('MenuItem');
        $this->setClassName('\\Menu\\Model\\MenuItem');
        $this->setPackage('Menu.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addForeignPrimaryKey('MENU_ID', 'MenuId', 'INTEGER' , 'menu', 'ID', true, null, null);
        $this->addColumn('VISIBLE', 'Visible', 'TINYINT', true, null, 0);
        $this->addColumn('POSITION', 'Position', 'INTEGER', true, null, 0);
        $this->addColumn('TYPOBJ', 'Typobj', 'INTEGER', false, null, 0);
        $this->addColumn('OBJET', 'Objet', 'INTEGER', false, null, 0);
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
        $this->addRelation('Menu', '\\Menu\\Model\\Menu', RelationMap::MANY_TO_ONE, array('menu_id' => 'id', ), 'CASCADE', 'RESTRICT');
        $this->addRelation('MenuItemVersion', '\\Menu\\Model\\MenuItemVersion', RelationMap::ONE_TO_MANY, array('id' => 'id', 'menu_id' => 'menu_id', ), 'CASCADE', null, 'MenuItemVersions');
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
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Menu\Model\MenuItem $obj A \Menu\Model\MenuItem object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize(array((string) $obj->getId(), (string) $obj->getMenuId()));
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Menu\Model\MenuItem object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Menu\Model\MenuItem) {
                $key = serialize(array((string) $value->getId(), (string) $value->getMenuId()));

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize(array((string) $value[0], (string) $value[1]));
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Menu\Model\MenuItem object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }
    /**
     * Method to invalidate the instance pool of all tables related to menu_item     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                MenuItemVersionTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MenuId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize(array((string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('MenuId', TableMap::TYPE_PHPNAME, $indexType)]));
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

            return $pks;
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
        return $withPrefix ? MenuItemTableMap::CLASS_DEFAULT : MenuItemTableMap::OM_CLASS;
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
     * @return array (MenuItem object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MenuItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MenuItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MenuItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MenuItemTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MenuItemTableMap::addInstanceToPool($obj, $key);
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
            $key = MenuItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MenuItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MenuItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MenuItemTableMap::ID);
            $criteria->addSelectColumn(MenuItemTableMap::MENU_ID);
            $criteria->addSelectColumn(MenuItemTableMap::VISIBLE);
            $criteria->addSelectColumn(MenuItemTableMap::POSITION);
            $criteria->addSelectColumn(MenuItemTableMap::TYPOBJ);
            $criteria->addSelectColumn(MenuItemTableMap::OBJET);
            $criteria->addSelectColumn(MenuItemTableMap::CREATED_AT);
            $criteria->addSelectColumn(MenuItemTableMap::UPDATED_AT);
            $criteria->addSelectColumn(MenuItemTableMap::VERSION);
            $criteria->addSelectColumn(MenuItemTableMap::VERSION_CREATED_AT);
            $criteria->addSelectColumn(MenuItemTableMap::VERSION_CREATED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.MENU_ID');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.TYPOBJ');
            $criteria->addSelectColumn($alias . '.OBJET');
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
        return Propel::getServiceContainer()->getDatabaseMap(MenuItemTableMap::DATABASE_NAME)->getTable(MenuItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MenuItemTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MenuItemTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MenuItemTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a MenuItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or MenuItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Menu\Model\MenuItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MenuItemTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(MenuItemTableMap::ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(MenuItemTableMap::MENU_ID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = MenuItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MenuItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MenuItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the menu_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MenuItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MenuItem or Criteria object.
     *
     * @param mixed               $criteria Criteria or MenuItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MenuItem object
        }

        if ($criteria->containsKey(MenuItemTableMap::ID) && $criteria->keyContainsValue(MenuItemTableMap::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MenuItemTableMap::ID.')');
        }


        // Set the correct dbName
        $query = MenuItemQuery::create()->mergeWith($criteria);

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

} // MenuItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MenuItemTableMap::buildTableMap();
