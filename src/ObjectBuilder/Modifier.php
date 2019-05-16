<?php

declare(strict_types = 1);

namespace Rentpost\Propel\SoftDelete\ObjectBuilder;

use Propel\Generator\Builder\Om\AbstractOMBuilder;
use Rentpost\Propel\SoftDelete\Behavior;

/**
 * Handles all the Base model class modifications
 *
 * @author Jacob Thomason <jacob@rentpost.com>
 */
class Modifier
{

    /** @var Behavior */
    protected $behavior;

    /** @var AbstractOMBuilder */
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
     * @param string $filename
     * @param array $replacements
     */
    protected function renderTemplate(string $filename, array $replacements = []): string
    {
        return $this->builder->renderTemplate($filename, $replacements, '/ObjectBuilder/template/');
    }


    /**
     * Gets the setter column function name
     */
    protected function getColumnSetter(): string
    {
        return 'set' . $this->behavior->getColumnForParameter('deleted_column')->getPhpName();
    }


    /**
     * Object methods to add to model class
     *
     * @param AbstractOMBuilder $builder
     */
    public function objectMethods(AbstractOMBuilder $builder): string
    {
        $this->builder = $builder;
        $code = '';

        $this->addUndeleteMethod($code);

        return $code;
    }


    /**
     * Adds an `unDelete` method, which basically sets null on the deleted_column
     *
     * @param string $code
     */
    public function addUndeleteMethod(string &$code): void
    {
        $code .= $this->renderTemplate('unDelete', [
            'setter' => $this->getColumnSetter(),
        ]);
    }


    /**
     * Adds code for the preDelete hook method
     *
     * @param AbstractOMBuilder $builder
     */
    public function preDelete(AbstractOMBuilder $builder): string
    {
        return $this->renderTemplate('unDelete', [
            'classname' => $builder->getStubPeerBuilder()->getClassname(),
            'setter' => $this->getColumnSetter(),
            'addHooks' => $builder->getGeneratorConfig()->getConfigProperty('addHooks'), // ->get()['generator']['objectModel']['addHooks']
        ]);
    }
}
