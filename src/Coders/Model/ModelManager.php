<?php

/**
 * Created by Cristian.
 * Date: 02/10/16 08:24 PM.
 */

namespace Codemax\Coders\Model;

use ArrayIterator;
use IteratorAggregate;
use Illuminate\Support\Arr;

class ModelManager implements IteratorAggregate
{
    /**
     * @var \Codemax\Coders\Model\Factory
     */
    protected $factory;

    /**
     * @var \Codemax\Coders\Model\Model[]
     */
    protected $models = [];

    /**
     * ModelManager constructor.
     *
     * @param \Codemax\Coders\Model\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $schema
     * @param string $table
     * @param \Codemax\Coders\Model\Mutator[] $mutators
     * @param bool $withRelations
     *
     * @return \Codemax\Coders\Model\Model
     */
    public function make($schema, $table, $mutators = [], $withRelations = true)
    {
        $mapper = $this->factory->makeSchema($schema);

        $blueprint = $mapper->table($table);

        if (Arr::has($this->models, $blueprint->qualifiedTable())) {
            return $this->models[$schema][$table];
        }

        $model = new Model($blueprint, $this->factory, $mutators, $withRelations);

        if ($withRelations) {
            $this->models[$schema][$table] = $model;
        }

        return $model;
    }

    /**
     * Get Models iterator.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->models);
    }
}
