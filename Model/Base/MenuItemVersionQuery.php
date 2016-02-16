<?php

namespace Menu\Model\Base;

use \Exception;
use \PDO;
use Menu\Model\MenuItemVersion as ChildMenuItemVersion;
use Menu\Model\MenuItemVersionQuery as ChildMenuItemVersionQuery;
use Menu\Model\Map\MenuItemVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'menu_item_version' table.
 *
 *
 *
 * @method     ChildMenuItemVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMenuItemVersionQuery orderByMenuId($order = Criteria::ASC) Order by the menu_id column
 * @method     ChildMenuItemVersionQuery orderByVisible($order = Criteria::ASC) Order by the visible column
 * @method     ChildMenuItemVersionQuery orderByPosition($order = Criteria::ASC) Order by the position column
 * @method     ChildMenuItemVersionQuery orderByTypobj($order = Criteria::ASC) Order by the typobj column
 * @method     ChildMenuItemVersionQuery orderByObjet($order = Criteria::ASC) Order by the objet column
 * @method     ChildMenuItemVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildMenuItemVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildMenuItemVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildMenuItemVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildMenuItemVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 * @method     ChildMenuItemVersionQuery orderByMenuIdVersion($order = Criteria::ASC) Order by the menu_id_version column
 *
 * @method     ChildMenuItemVersionQuery groupById() Group by the id column
 * @method     ChildMenuItemVersionQuery groupByMenuId() Group by the menu_id column
 * @method     ChildMenuItemVersionQuery groupByVisible() Group by the visible column
 * @method     ChildMenuItemVersionQuery groupByPosition() Group by the position column
 * @method     ChildMenuItemVersionQuery groupByTypobj() Group by the typobj column
 * @method     ChildMenuItemVersionQuery groupByObjet() Group by the objet column
 * @method     ChildMenuItemVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildMenuItemVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildMenuItemVersionQuery groupByVersion() Group by the version column
 * @method     ChildMenuItemVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildMenuItemVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 * @method     ChildMenuItemVersionQuery groupByMenuIdVersion() Group by the menu_id_version column
 *
 * @method     ChildMenuItemVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMenuItemVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMenuItemVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMenuItemVersionQuery leftJoinMenuItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the MenuItem relation
 * @method     ChildMenuItemVersionQuery rightJoinMenuItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MenuItem relation
 * @method     ChildMenuItemVersionQuery innerJoinMenuItem($relationAlias = null) Adds a INNER JOIN clause to the query using the MenuItem relation
 *
 * @method     ChildMenuItemVersion findOne(ConnectionInterface $con = null) Return the first ChildMenuItemVersion matching the query
 * @method     ChildMenuItemVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMenuItemVersion matching the query, or a new ChildMenuItemVersion object populated from the query conditions when no match is found
 *
 * @method     ChildMenuItemVersion findOneById(int $id) Return the first ChildMenuItemVersion filtered by the id column
 * @method     ChildMenuItemVersion findOneByMenuId(int $menu_id) Return the first ChildMenuItemVersion filtered by the menu_id column
 * @method     ChildMenuItemVersion findOneByVisible(int $visible) Return the first ChildMenuItemVersion filtered by the visible column
 * @method     ChildMenuItemVersion findOneByPosition(int $position) Return the first ChildMenuItemVersion filtered by the position column
 * @method     ChildMenuItemVersion findOneByTypobj(int $typobj) Return the first ChildMenuItemVersion filtered by the typobj column
 * @method     ChildMenuItemVersion findOneByObjet(int $objet) Return the first ChildMenuItemVersion filtered by the objet column
 * @method     ChildMenuItemVersion findOneByCreatedAt(string $created_at) Return the first ChildMenuItemVersion filtered by the created_at column
 * @method     ChildMenuItemVersion findOneByUpdatedAt(string $updated_at) Return the first ChildMenuItemVersion filtered by the updated_at column
 * @method     ChildMenuItemVersion findOneByVersion(int $version) Return the first ChildMenuItemVersion filtered by the version column
 * @method     ChildMenuItemVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildMenuItemVersion filtered by the version_created_at column
 * @method     ChildMenuItemVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildMenuItemVersion filtered by the version_created_by column
 * @method     ChildMenuItemVersion findOneByMenuIdVersion(int $menu_id_version) Return the first ChildMenuItemVersion filtered by the menu_id_version column
 *
 * @method     array findById(int $id) Return ChildMenuItemVersion objects filtered by the id column
 * @method     array findByMenuId(int $menu_id) Return ChildMenuItemVersion objects filtered by the menu_id column
 * @method     array findByVisible(int $visible) Return ChildMenuItemVersion objects filtered by the visible column
 * @method     array findByPosition(int $position) Return ChildMenuItemVersion objects filtered by the position column
 * @method     array findByTypobj(int $typobj) Return ChildMenuItemVersion objects filtered by the typobj column
 * @method     array findByObjet(int $objet) Return ChildMenuItemVersion objects filtered by the objet column
 * @method     array findByCreatedAt(string $created_at) Return ChildMenuItemVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildMenuItemVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildMenuItemVersion objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildMenuItemVersion objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildMenuItemVersion objects filtered by the version_created_by column
 * @method     array findByMenuIdVersion(int $menu_id_version) Return ChildMenuItemVersion objects filtered by the menu_id_version column
 *
 */
abstract class MenuItemVersionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Menu\Model\Base\MenuItemVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Menu\\Model\\MenuItemVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMenuItemVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMenuItemVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Menu\Model\MenuItemVersionQuery) {
            return $criteria;
        }
        $query = new \Menu\Model\MenuItemVersionQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$id, $menu_id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMenuItemVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MenuItemVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MenuItemVersionTableMap::DATABASE_NAME);
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
     * @return   ChildMenuItemVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, MENU_ID, VISIBLE, POSITION, TYPOBJ, OBJET, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY, MENU_ID_VERSION FROM menu_item_version WHERE ID = :p0 AND MENU_ID = :p1 AND VERSION = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildMenuItemVersion();
            $obj->hydrate($row);
            MenuItemVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return ChildMenuItemVersion|array|mixed the result, formatted by the current formatter
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MenuItemVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(MenuItemVersionTableMap::VERSION, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MenuItemVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MenuItemVersionTableMap::MENU_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(MenuItemVersionTableMap::VERSION, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
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
     * @see       filterByMenuItem()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::ID, $id, $comparison);
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
     * @see       filterByMenuItem()
     *
     * @param     mixed $menuId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByMenuId($menuId = null, $comparison = null)
    {
        if (is_array($menuId)) {
            $useMinMax = false;
            if (isset($menuId['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID, $menuId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($menuId['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID, $menuId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID, $menuId, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByVisible($visible = null, $comparison = null)
    {
        if (is_array($visible)) {
            $useMinMax = false;
            if (isset($visible['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::VISIBLE, $visible['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visible['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::VISIBLE, $visible['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::VISIBLE, $visible, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByPosition($position = null, $comparison = null)
    {
        if (is_array($position)) {
            $useMinMax = false;
            if (isset($position['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::POSITION, $position['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($position['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::POSITION, $position['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::POSITION, $position, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByTypobj($typobj = null, $comparison = null)
    {
        if (is_array($typobj)) {
            $useMinMax = false;
            if (isset($typobj['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::TYPOBJ, $typobj['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typobj['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::TYPOBJ, $typobj['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::TYPOBJ, $typobj, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByObjet($objet = null, $comparison = null)
    {
        if (is_array($objet)) {
            $useMinMax = false;
            if (isset($objet['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::OBJET, $objet['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objet['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::OBJET, $objet['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::OBJET, $objet, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MenuItemVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query on the menu_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByMenuIdVersion(1234); // WHERE menu_id_version = 1234
     * $query->filterByMenuIdVersion(array(12, 34)); // WHERE menu_id_version IN (12, 34)
     * $query->filterByMenuIdVersion(array('min' => 12)); // WHERE menu_id_version > 12
     * </code>
     *
     * @param     mixed $menuIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByMenuIdVersion($menuIdVersion = null, $comparison = null)
    {
        if (is_array($menuIdVersion)) {
            $useMinMax = false;
            if (isset($menuIdVersion['min'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID_VERSION, $menuIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($menuIdVersion['max'])) {
                $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID_VERSION, $menuIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemVersionTableMap::MENU_ID_VERSION, $menuIdVersion, $comparison);
    }

    /**
     * Filter the query by a related \Menu\Model\MenuItem object
     *
     * @param \Menu\Model\MenuItem $menuItem The related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function filterByMenuItem($menuItem, $comparison = null)
    {
        if ($menuItem instanceof \Menu\Model\MenuItem) {
            return $this
                ->addUsingAlias(MenuItemVersionTableMap::ID, $menuItem->getId(), $comparison)
                ->addUsingAlias(MenuItemVersionTableMap::MENU_ID, $menuItem->getMenuId(), $comparison);
        } else {
            throw new PropelException('filterByMenuItem() only accepts arguments of type \Menu\Model\MenuItem');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MenuItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function joinMenuItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MenuItem');

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
            $this->addJoinObject($join, 'MenuItem');
        }

        return $this;
    }

    /**
     * Use the MenuItem relation MenuItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Menu\Model\MenuItemQuery A secondary query class using the current class as primary query
     */
    public function useMenuItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMenuItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MenuItem', '\Menu\Model\MenuItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMenuItemVersion $menuItemVersion Object to remove from the list of results
     *
     * @return ChildMenuItemVersionQuery The current query, for fluid interface
     */
    public function prune($menuItemVersion = null)
    {
        if ($menuItemVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MenuItemVersionTableMap::ID), $menuItemVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MenuItemVersionTableMap::MENU_ID), $menuItemVersion->getMenuId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(MenuItemVersionTableMap::VERSION), $menuItemVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the menu_item_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemVersionTableMap::DATABASE_NAME);
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
            MenuItemVersionTableMap::clearInstancePool();
            MenuItemVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMenuItemVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMenuItemVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MenuItemVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MenuItemVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MenuItemVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MenuItemVersionQuery
