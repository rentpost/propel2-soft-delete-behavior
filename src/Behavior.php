<?php

declare(strict_types = 1);

namespace Rentpost\Propel\SoftDelete;

use Propel\Generator\Model\Behavior as BaseBehavior;
use Rentpost\Propel\SoftDelete\ObjectBuilder\Modifier as ObjectBuilderModifier;
use Rentpost\Propel\SoftDelete\QueryBuilder\Modifier as QueryBuilderModifier;

/**
 * Adds soft_delete behavior to Propel models
 *
 * @author Jacob Thomason <jacob@rentpost.com>
 */
class Behavior extends BaseBehavior
{

    /** @var array */
    protected $parameters = [
        'deleted_column' => 'deleted_at',
    ];

    /** @var QueryBuilderModifier */
    protected $queryBuilderModifier;

    /** @var QueryBuilderModifier */
    protected $objectBuilderModifier;


    /**
     * {@inheritdoc}
     */
    public function getObjectBuilderModifier()
    {
        if (!$this->objectBuilderModifier) {
            $this->objectBuilderModifier = new ObjectBuilderModifier($this);
        }

        return $this->objectBuilderModifier;
    }


    /**
     * {@inheritdoc}
     */
    public function getQueryBuilderModifier()
    {
        if (!$this->queryBuilderModifier) {
            $this->queryBuilderModifier = new QueryBuilderModifier($this);
        }

        return $this->queryBuilderModifier;
    }


    /**
     * Add the deleted_column to the current table
     */
    public function modifyTable(): void
    {
        if ($this->getTable()->hasColumn($this->getParameter('deleted_column'))) {
            return;
        }

        $this->getTable()->addColumn([
            'name' => $this->getParameter('deleted_column'),
            'type' => 'TIMESTAMP',
        ]);
    }
}
