<?php

namespace Menu\Model\Base;

use \Exception;
use \PDO;
use Menu\Model\MenuItemI18nVersion as ChildMenuItemI18nVersion;
use Menu\Model\MenuItemI18nVersionQuery as ChildMenuItemI18nVersionQuery;
use Menu\Model\Map\MenuItemI18nVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'menu_item_i18n_version' table.
 *
 *
 *
 * @method     ChildMenuItemI18nVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMenuItemI18nVersionQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildMenuItemI18nVersionQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildMenuItemI18nVersionQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildMenuItemI18nVersionQuery orderByChapo($order = Criteria::ASC) Order by the chapo column
 * @method     ChildMenuItemI18nVersionQuery orderByPostscriptum($order = Criteria::ASC) Order by the postscriptum column
 * @method     ChildMenuItemI18nVersionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildMenuItemI18nVersionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 * @method     ChildMenuItemI18nVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildMenuItemI18nVersionQuery orderByVersionCreatedAt($order = Criteria::ASC) Order by the version_created_at column
 * @method     ChildMenuItemI18nVersionQuery orderByVersionCreatedBy($order = Criteria::ASC) Order by the version_created_by column
 *
 * @method     ChildMenuItemI18nVersionQuery groupById() Group by the id column
 * @method     ChildMenuItemI18nVersionQuery groupByLocale() Group by the locale column
 * @method     ChildMenuItemI18nVersionQuery groupByTitle() Group by the title column
 * @method     ChildMenuItemI18nVersionQuery groupByDescription() Group by the description column
 * @method     ChildMenuItemI18nVersionQuery groupByChapo() Group by the chapo column
 * @method     ChildMenuItemI18nVersionQuery groupByPostscriptum() Group by the postscriptum column
 * @method     ChildMenuItemI18nVersionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildMenuItemI18nVersionQuery groupByUpdatedAt() Group by the updated_at column
 * @method     ChildMenuItemI18nVersionQuery groupByVersion() Group by the version column
 * @method     ChildMenuItemI18nVersionQuery groupByVersionCreatedAt() Group by the version_created_at column
 * @method     ChildMenuItemI18nVersionQuery groupByVersionCreatedBy() Group by the version_created_by column
 *
 * @method     ChildMenuItemI18nVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMenuItemI18nVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMenuItemI18nVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMenuItemI18nVersionQuery leftJoinMenuItemI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the MenuItemI18n relation
 * @method     ChildMenuItemI18nVersionQuery rightJoinMenuItemI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MenuItemI18n relation
 * @method     ChildMenuItemI18nVersionQuery innerJoinMenuItemI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the MenuItemI18n relation
 *
 * @method     ChildMenuItemI18nVersion findOne(ConnectionInterface $con = null) Return the first ChildMenuItemI18nVersion matching the query
 * @method     ChildMenuItemI18nVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMenuItemI18nVersion matching the query, or a new ChildMenuItemI18nVersion object populated from the query conditions when no match is found
 *
 * @method     ChildMenuItemI18nVersion findOneById(int $id) Return the first ChildMenuItemI18nVersion filtered by the id column
 * @method     ChildMenuItemI18nVersion findOneByLocale(string $locale) Return the first ChildMenuItemI18nVersion filtered by the locale column
 * @method     ChildMenuItemI18nVersion findOneByTitle(string $title) Return the first ChildMenuItemI18nVersion filtered by the title column
 * @method     ChildMenuItemI18nVersion findOneByDescription(string $description) Return the first ChildMenuItemI18nVersion filtered by the description column
 * @method     ChildMenuItemI18nVersion findOneByChapo(string $chapo) Return the first ChildMenuItemI18nVersion filtered by the chapo column
 * @method     ChildMenuItemI18nVersion findOneByPostscriptum(string $postscriptum) Return the first ChildMenuItemI18nVersion filtered by the postscriptum column
 * @method     ChildMenuItemI18nVersion findOneByCreatedAt(string $created_at) Return the first ChildMenuItemI18nVersion filtered by the created_at column
 * @method     ChildMenuItemI18nVersion findOneByUpdatedAt(string $updated_at) Return the first ChildMenuItemI18nVersion filtered by the updated_at column
 * @method     ChildMenuItemI18nVersion findOneByVersion(int $version) Return the first ChildMenuItemI18nVersion filtered by the version column
 * @method     ChildMenuItemI18nVersion findOneByVersionCreatedAt(string $version_created_at) Return the first ChildMenuItemI18nVersion filtered by the version_created_at column
 * @method     ChildMenuItemI18nVersion findOneByVersionCreatedBy(string $version_created_by) Return the first ChildMenuItemI18nVersion filtered by the version_created_by column
 *
 * @method     array findById(int $id) Return ChildMenuItemI18nVersion objects filtered by the id column
 * @method     array findByLocale(string $locale) Return ChildMenuItemI18nVersion objects filtered by the locale column
 * @method     array findByTitle(string $title) Return ChildMenuItemI18nVersion objects filtered by the title column
 * @method     array findByDescription(string $description) Return ChildMenuItemI18nVersion objects filtered by the description column
 * @method     array findByChapo(string $chapo) Return ChildMenuItemI18nVersion objects filtered by the chapo column
 * @method     array findByPostscriptum(string $postscriptum) Return ChildMenuItemI18nVersion objects filtered by the postscriptum column
 * @method     array findByCreatedAt(string $created_at) Return ChildMenuItemI18nVersion objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return ChildMenuItemI18nVersion objects filtered by the updated_at column
 * @method     array findByVersion(int $version) Return ChildMenuItemI18nVersion objects filtered by the version column
 * @method     array findByVersionCreatedAt(string $version_created_at) Return ChildMenuItemI18nVersion objects filtered by the version_created_at column
 * @method     array findByVersionCreatedBy(string $version_created_by) Return ChildMenuItemI18nVersion objects filtered by the version_created_by column
 *
 */
abstract class MenuItemI18nVersionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Menu\Model\Base\MenuItemI18nVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\Menu\\Model\\MenuItemI18nVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMenuItemI18nVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMenuItemI18nVersionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \Menu\Model\MenuItemI18nVersionQuery) {
            return $criteria;
        }
        $query = new \Menu\Model\MenuItemI18nVersionQuery();
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
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMenuItemI18nVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MenuItemI18nVersionTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MenuItemI18nVersionTableMap::DATABASE_NAME);
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
     * @return   ChildMenuItemI18nVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID, LOCALE, TITLE, DESCRIPTION, CHAPO, POSTSCRIPTUM, CREATED_AT, UPDATED_AT, VERSION, VERSION_CREATED_AT, VERSION_CREATED_BY FROM menu_item_i18n_version WHERE ID = :p0 AND VERSION = :p1';
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
            $obj = new ChildMenuItemI18nVersion();
            $obj->hydrate($row);
            MenuItemI18nVersionTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildMenuItemI18nVersion|array|mixed the result, formatted by the current formatter
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
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(MenuItemI18nVersionTableMap::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(MenuItemI18nVersionTableMap::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(MenuItemI18nVersionTableMap::VERSION, $key[1], Criteria::EQUAL);
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
     * @see       filterByMenuItemI18n()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $locale)) {
                $locale = str_replace('*', '%', $locale);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the chapo column
     *
     * Example usage:
     * <code>
     * $query->filterByChapo('fooValue');   // WHERE chapo = 'fooValue'
     * $query->filterByChapo('%fooValue%'); // WHERE chapo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $chapo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByChapo($chapo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($chapo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $chapo)) {
                $chapo = str_replace('*', '%', $chapo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::CHAPO, $chapo, $comparison);
    }

    /**
     * Filter the query on the postscriptum column
     *
     * Example usage:
     * <code>
     * $query->filterByPostscriptum('fooValue');   // WHERE postscriptum = 'fooValue'
     * $query->filterByPostscriptum('%fooValue%'); // WHERE postscriptum LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postscriptum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByPostscriptum($postscriptum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postscriptum)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postscriptum)) {
                $postscriptum = str_replace('*', '%', $postscriptum);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::POSTSCRIPTUM, $postscriptum, $comparison);
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
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::CREATED_AT, $createdAt, $comparison);
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
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::UPDATED_AT, $updatedAt, $comparison);
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
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION, $version, $comparison);
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
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByVersionCreatedAt($versionCreatedAt = null, $comparison = null)
    {
        if (is_array($versionCreatedAt)) {
            $useMinMax = false;
            if (isset($versionCreatedAt['min'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionCreatedAt['max'])) {
                $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION_CREATED_AT, $versionCreatedAt, $comparison);
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
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(MenuItemI18nVersionTableMap::VERSION_CREATED_BY, $versionCreatedBy, $comparison);
    }

    /**
     * Filter the query by a related \Menu\Model\MenuItemI18n object
     *
     * @param \Menu\Model\MenuItemI18n|ObjectCollection $menuItemI18n The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function filterByMenuItemI18n($menuItemI18n, $comparison = null)
    {
        if ($menuItemI18n instanceof \Menu\Model\MenuItemI18n) {
            return $this
                ->addUsingAlias(MenuItemI18nVersionTableMap::ID, $menuItemI18n->getId(), $comparison);
        } elseif ($menuItemI18n instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MenuItemI18nVersionTableMap::ID, $menuItemI18n->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByMenuItemI18n() only accepts arguments of type \Menu\Model\MenuItemI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MenuItemI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function joinMenuItemI18n($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MenuItemI18n');

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
            $this->addJoinObject($join, 'MenuItemI18n');
        }

        return $this;
    }

    /**
     * Use the MenuItemI18n relation MenuItemI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Menu\Model\MenuItemI18nQuery A secondary query class using the current class as primary query
     */
    public function useMenuItemI18nQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMenuItemI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MenuItemI18n', '\Menu\Model\MenuItemI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMenuItemI18nVersion $menuItemI18nVersion Object to remove from the list of results
     *
     * @return ChildMenuItemI18nVersionQuery The current query, for fluid interface
     */
    public function prune($menuItemI18nVersion = null)
    {
        if ($menuItemI18nVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(MenuItemI18nVersionTableMap::ID), $menuItemI18nVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(MenuItemI18nVersionTableMap::VERSION), $menuItemI18nVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the menu_item_i18n_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemI18nVersionTableMap::DATABASE_NAME);
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
            MenuItemI18nVersionTableMap::clearInstancePool();
            MenuItemI18nVersionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMenuItemI18nVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMenuItemI18nVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MenuItemI18nVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MenuItemI18nVersionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MenuItemI18nVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MenuItemI18nVersionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MenuItemI18nVersionQuery
