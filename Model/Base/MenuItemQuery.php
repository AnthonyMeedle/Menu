<?php

namespace Menu\Model\Base;

use \Exception;
use \PDO;
use Menu\Model\MenuItem as ChildMenuItem;
use Menu\Model\MenuItemQuery as ChildMenuItemQuery;
use Menu\Model\Map\MenuItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'menu_item' table.
 *
 *
 *
 * @method     ChildMenuItemQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMenuItemQuery orderByMenuId($order = Criteria::ASC) Order by the menu_id column
 * @method     ChildMenuItemQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildMenuItemQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildMenuItemQuery orderByTypobj($order = Criteria::ASC) Order by the typobj column
 * @method     ChildMenuItemQuery orderByObjet($order = Criteria::ASC) Order by the objet column
 * @method     ChildMenuItemQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildMenuItemQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildMenuItemQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildMenuItemQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildMenuItemQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildMenuItemQuery groupById() Group by the id column
 * @method     ChildMenuItemQuery groupByMenuId() Group by the menu_id column
 * @method     ChildMenuItemQuery groupByVisible() Group by the visible column
 * @method     ChildMenuItemQuery groupByPosition() Group by the position column
 * @method     ChildMenuItemQuery groupByTypobj() Group by the typobj column
 * @method     ChildMenuItemQuery groupByObjet() Group by the objet column
 * @method     ChildMenuItemQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildMenuItemQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildMenuItemQuery groupByVersion() Group by the version column
 * @method     ChildMenuItemQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildMenuItemQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildMenuItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMenuItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMenuItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMenuItemQuery leftJoinMenu($relationAlias = null) Adds a LEFT JOIN clause to the query using the Menu relation
 * @method     ChildMenuItemQuery rightJoinMenu($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Menu relation
 * @method     ChildMenuItemQuery innerJoinMenu($relationAlias = null) Adds a INNER JOIN clause to the query using the Menu relation
 *
 * @method     ChildMenuItemQuery leftJoinMenuItemVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the MenuItemVersion relation
 * @method     ChildMenuItemQuery rightJoinMenuItemVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MenuItemVersion relation
 * @method     ChildMenuItemQuery innerJoinMenuItemVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the MenuItemVersion relation
 *
 * @method     ChildMenuItem findOne(ConnectionInterface $con = null) Return the first ChildMenuItem matching the query
 * @method     ChildMenuItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMenuItem matching the query, or a new ChildMenuItem object populated from the query conditions when no match is found
 *
 * @method     ChildMenuItem findOneById(int $id) Return the first ChildMenuItem filtered by the id column
 * @method     ChildMenuItem findOneByMenuId(int $menu_id) Return the first ChildMenuItem filtered by the menu_id column
 * @method     ChildMenuItem findOneByVisible(int $visible) Return the first ChildMenuItem filtered by the visible column
 * @method     ChildMenuItem findOneByPosition(int $position) Return the first ChildMenuItem filtered by the position column
 * @method     ChildMenuItem findOneByTypobj(int $typobj) Return the first ChildMenuItem filtered by the typobj column
 * @method     ChildMenuItem findOneByObjet(int $objet) Return the first ChildMenuItem filtered by the objet column
 * @method     ChildMenuItem findOneByCreatedAt(string $created_at) Return the first ChildMenuItem filtered by the created_at column
 * @method     ChildMenuItem findOneByUpdatedAt(string $updated_at) Return the first ChildMenuItem filtered by the updated_at column
 * @method     ChildMenuItem findOneByVersion(int $version) Return the first ChildMenuItem filtered by the version column
 * @method     ChildMenuItem findOneByVersionCreatedAt(string $version_created_at) Return the first ChildMenuItem filtered by the version_created_at column
 * @method     ChildMenuItem findOneByVersionCreatedBy(string $version_created_by) Return the first ChildMenuItem filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildMenuItem objects filtered by the id column
 * @method     array findByMenuId(int $menu_id) Return ChildMenuItem objects filtered by the menu_id column
 * @method     array findByVisible(int $visible) Return ChildMenuItem objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildMenuItem objects filtered by the position column
 * @method     array findByTypobj(int $typobj) Return ChildMenuItem objects filtered by the typobj column
 * @method     array findByObjet(int $objet) Return ChildMenuItem objects filtered by the objet column
 * @method     array findByCreatedAt(string $created_at) Return ChildMenuItem objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildMenuItem objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildMenuItem objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildMenuItem objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildMenuItem objects filtered by the version_created_by column
 *
 */
abstract class MenuItemQuery extends ModelCriteria
{

    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;

    /**
     * Initializes internal state of \Menu\Model\Base\MenuItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Menu\\Model\\MenuItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMenuItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMenuItemQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Menu\Model\MenuItemQuery) {
            return $criteria;
        }
        $query = new \Menu\Model\MenuItemQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $menu_id] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMenuItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MenuItemTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MenuItemTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildMenuItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, MENU_ID, VISIBLE, POSITION, TYPOBJ, OBJET, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM menu_item WHERE ID = :p0 AND MENU_ID = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildMenuItem();
            $obj->hydrate($row);
            MenuItemTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMenuItem|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MenuItemTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MenuItemTableMap::MENU_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MenuItemTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MenuItemTableMap::MENU_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MenuItemTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MenuItemTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the menu_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMenuId(1234); // WHERE menu_id = 1234
     * $query->filterByMenuId(array(12, 34)); // WHERE menu_id IN (12, 34)
     * $query->filterByMenuId(array('min' => 12)); // WHERE menu_id > 12
     * </code>
     *
     * @see       filterByMenu()
     *
     * @param     mixed $menuId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByMenuId($menuId = null, $comparison = null)
    {
        if (is_array($menuId)) {
            $useMinMax = false;
            if (isset($menuId['min'])) {
                $this->addUsingAlias(MenuItemTableMap::MENU_ID, $menuId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($menuId['max'])) {
                $this->addUsingAlias(MenuItemTableMap::MENU_ID, $menuId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::MENU_ID, $menuId, $comparison);
    }

    /**
     * Filter the query on the visible column
     *
     * Example usage:
     * <code>
     * $query->filterByVisible(1234); // WHERE visible = 1234
     * $query->filterByVisible(array(12, 34)); // WHERE visible IN (12, 34)
     * $query->filterByVisible(array('min' => 12)); // WHERE visible > 12
     * </code>
     *
     * @param     mixed $visible The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(MenuItemTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(MenuItemTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::VISIBLE, $visible, $comparison);
    }

    /**
     * Filter the query on the position column
     *
     * Example usage:
     * <code>
     * $query->filterByPosition(1234); // WHERE position = 1234
     * $query->filterByPosition(array(12, 34)); // WHERE position IN (12, 34)
     * $query->filterByPosition(array('min' => 12)); // WHERE position > 12
     * </code>
     *
     * @param     mixed $position The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(MenuItemTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(MenuItemTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::POSITION, $position, $comparison);
    }

    /**
     * Filter the query on the typobj column
     *
     * Example usage:
     * <code>
     * $query->filterByTypobj(1234); // WHERE typobj = 1234
     * $query->filterByTypobj(array(12, 34)); // WHERE typobj IN (12, 34)
     * $query->filterByTypobj(array('min' => 12)); // WHERE typobj > 12
     * </code>
     *
     * @param     mixed $typobj The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByTypobj($typobj = null, $comparison = null)
    {
        if (is_array($typobj)) {
            $useMinMax = false;
            if (isset($typobj['min'])) {
                $this->addUsingAlias(MenuItemTableMap::TYPOBJ, $typobj['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typobj['max'])) {
                $this->addUsingAlias(MenuItemTableMap::TYPOBJ, $typobj['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::TYPOBJ, $typobj, $comparison);
    }

    /**
     * Filter the query on the objet column
     *
     * Example usage:
     * <code>
     * $query->filterByObjet(1234); // WHERE objet = 1234
     * $query->filterByObjet(array(12, 34)); // WHERE objet IN (12, 34)
     * $query->filterByObjet(array('min' => 12)); // WHERE objet > 12
     * </code>
     *
     * @param     mixed $objet The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByObjet($objet = null, $comparison = null)
    {
        if (is_array($objet)) {
            $useMinMax = false;
            if (isset($objet['min'])) {
                $this->addUsingAlias(MenuItemTableMap::OBJET, $objet['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objet['max'])) {
                $this->addUsingAlias(MenuItemTableMap::OBJET, $objet['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::OBJET, $objet, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MenuItemTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MenuItemTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MenuItemTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MenuItemTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(MenuItemTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(MenuItemTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the version_created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedAt('2011-03-14'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt('now'); // WHERE version_created_at = '2011-03-14'
     * $query->filterByVersionCreatedAt(array('max' => 'yesterday')); // WHERE version_created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $versionCreatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(MenuItemTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(MenuItemTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
    }

    /**
     * Filter the query on the version_created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionCreatedBy('fooValue');   // WHERE version_created_by = 'fooValue'
     * $query->filterByVersionCreatedBy('%fooValue%'); // WHERE version_created_by LIKE '%fooValue%'
     * </code>
     *
     * @param     string $versionCreatedBy The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedBy($versionCreatedBy = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($versionCreatedBy)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $versionCreatedBy)) {
                $versionCreatedBy = str_replace('*', '%', $versionCreatedBy);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenuItemTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Menu\Model\Menu object
     *
     * @param \Menu\Model\Menu|ObjectCollection $menu The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByMenu($menu, $comparison = null)
    {
        if ($menu instanceof \Menu\Model\Menu) {
            return $this
                ->addUsingAlias(MenuItemTableMap::MENU_ID, $menu->getId(), $comparison);
        } elseif ($menu instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MenuItemTableMap::MENU_ID, $menu->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMenu() only accepts arguments of type \Menu\Model\Menu or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Menu relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function joinMenu($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Menu');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Menu');
        }

        return $this;
    }

    /**
     * Use the Menu relation Menu object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Menu\Model\MenuQuery A secondary query class using the current class as primary query
     */
    public function useMenuQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMenu($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Menu', '\Menu\Model\MenuQuery');
    }

    /**
     * Filter the query by a related \Menu\Model\MenuItemVersion object
     *
     * @param \Menu\Model\MenuItemVersion|ObjectCollection $menuItemVersion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function filterByMenuItemVersion($menuItemVersion, $comparison = null)
    {
        if ($menuItemVersion instanceof \Menu\Model\MenuItemVersion) {
            return $this
                ->addUsingAlias(MenuItemTableMap::ID, $menuItemVersion->getId(), $comparison)
                ->addUsingAlias(MenuItemTableMap::MENU_ID, $menuItemVersion->getMenuId(), $comparison);
        } else {
            throw new PropelException('filterByMenuItemVersion() only accepts arguments of type \Menu\Model\MenuItemVersion');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MenuItemVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function joinMenuItemVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MenuItemVersion');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'MenuItemVersion');
        }

        return $this;
    }

    /**
     * Use the MenuItemVersion relation MenuItemVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Menu\Model\MenuItemVersionQuery A secondary query class using the current class as primary query
     */
    public function useMenuItemVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMenuItemVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MenuItemVersion', '\Menu\Model\MenuItemVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMenuItem $menuItem Object to remove from the list of results
     *
     * @return ChildMenuItemQuery The current query, for fluid interface
     */
    public function prune($menuItem = null)
    {
        if ($menuItem) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MenuItemTableMap::ID), $menuItem->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MenuItemTableMap::MENU_ID), $menuItem->getMenuId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the menu_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MenuItemTableMap::clearInstancePool();
            MenuItemTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMenuItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMenuItem object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MenuItemTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MenuItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MenuItemTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     ChildMenuItemQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(MenuItemTableMap::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     ChildMenuItemQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(MenuItemTableMap::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     ChildMenuItemQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(MenuItemTableMap::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     ChildMenuItemQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(MenuItemTableMap::UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     ChildMenuItemQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(MenuItemTableMap::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     ChildMenuItemQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(MenuItemTableMap::CREATED_AT);
    }

    // versionable behavior

    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }

    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }

    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // MenuItemQuery
