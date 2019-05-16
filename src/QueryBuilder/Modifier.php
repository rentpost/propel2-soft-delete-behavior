<?php

declare(strict_types = 1);

namespace Rentpost\Propel\SoftDelete\QueryBuilder;

use Propel\Generator\Builder\Om\QueryBuilder;
use Rentpost\Propel\SoftDelete\Behavior;

/**
 * Handles all the Query class modifications
 *
 * @author Jacob Thomason <jacob@rentpost.com>
 */
class Modifier
{

    /** @var Behavior */
    protected $behavior;

    /** @var QueryBuilder */
    protected $builder;


    /**
     * Constructor
     *
     * @param Behavior $behavior
     */
    public function __construct(Behavior $behavior)
    {
        $this->behavior = $behavior;
    }


    /**
     * Alias shortcut method to define the template directory
     *
     * @see https://github.com/propelorm/Propel2/pull/1513
     *
     * @param string $filename
     * @param array $replacements
     */
    protected function renderTemplate(string $filename, array $replacements = []): string
    {
        return $this->builder->renderTemplate(
            $filename,
            $replacements,
            '/../../../../../../../rentpost/propel2-soft-delete-behavior/src/QueryBuilder/template/', // Blame Propel
        );
    }


    /**
     * Properties to be added to the Query builder class
     */
    public function queryAttributes(): string
    {
        $attr = 'protected static $softDelete = true;';
        $attr .= 'protected $localSoftDelete = true';

        return $attr;
    }


    /**
     * Query methods to be added to the base Query builder class
     *
     * @param QueryBuilder $builder
     */
    public function queryMethods(QueryBuilder $builder): string
    {
        $this->builder = $builder;
        $code = '';

        $this->addIncludeDeletedMethod($code);
        $this->addSoftDeleteMethod($code);
        $this->addForceDeleteMethod($code);
        $this->addForceDeleteAllMethod($code);
        $this->addUnDeleteMethod($code);
        $this->addEnableSoftDeleteMethod($code);
        $this->addDisableSoftDeleteMethod($code);
        $this->addIsSoftDeleteEnabledMethod($code);

        return $code;
    }


    /**
     * Adds a query method to include deleted_column results
     *
     * @param string $code
     */
    public function addIncludeDeletedMethod(string &$code): void
    {
        $code = $this->renderTemplate('includeDeleted');
    }


    /**
     * Adds a query method to set the delete_at value, effectively setting a record as soft deleted.
     *
     * @param string $code
     */
    public function addSoftDeleteMethod(string &$code): void
    {
        $code = $this->renderTemplate('softDelete', [
            'deletedColumn' => $this->behavior->getColumnForParameter('deleted_column')->getPhpName(),
        ]);
    }


    /**
     * Adds a query method that actually deletes the resulting record of the formed query
     *
     * @param string $code
     */
    public function addForceDeleteMethod(string &$code): void
    {
        $code = $this->renderTemplate('forceDelete');
    }


    /**
     * Adds a query method that actually deletes the resulting records of the formed query
     *
     * @param string $code
     */
    public function addForceDeleteAllMethod(string &$code): void
    {
        $code = $this->renderTemplate('forceDeleteAll');
    }


    /**
     * Adds a query method that marks a record as "undeleted", basically setting deleted_column to null
     *
     * @param string $code
     */
    public function addUnDeleteMethod(string &$code): void
    {
        $code = $this->renderTemplate('unDelete', [
            'deletedColumn' => $this->behavior->getColumnForParameter('deleted_column')->getPhpName(),
        ]);
    }


    /**
     * Adds a query method that enables soft delete for the query
     *
     * @param string $code
     */
    public function addEnableSoftDeleteMethod(string &$code): void
    {
        $code = $this->renderTemplate('enableSoftDelete');
    }


    /**
     * Adds a query method that disables soft delete fore the query
     *
     * @param string $code
     */
    public function addDisableSoftDeleteMethod(string &$code): void
    {
        $code = $this->renderTemplate('disableSoftDelete');
    }


    /**
     * Adds a query method that checks to see if soft_delete has been enabled for the current query
     *
     * @param string $code
     */
    public function addIsSoftDeleteEnabledMethod(string &$code): void
    {
        $code = $this->renderTemplate('isSoftDeleteEnabled');
    }


    /**
     * Adds the preSelect method logic
     *
     * @param QueryBuilder $builder
     *
     * @return string
     */
    public function preSelectQuery(QueryBuilder $builder): string
    {
        $this->builder = $builder;

        return $this->renderTemplate('preSelectQuery', [
            'deletedColumn' => $this->behavior->getColumnForParameter('deleted_column')->getPhpName(),
            'classname' => $builder->getStubQueryBuilder()->getClassname(),
        ]);
    }


    /**
     * Adds the preDelete method logic
     *
     * @param QueryBuilder $builder
     */
    public function preDeleteQuery(QueryBuilder $builder): string
    {
        $this->builder = $builder;

        return $this->renderTemplate('preDeleteQuery', [
            'classname' => $builder->getStubQueryBuilder()->getClassname(),
        ]);
    }
}
