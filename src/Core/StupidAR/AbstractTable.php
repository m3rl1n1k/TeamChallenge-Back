<?php

namespace App\Core\StupidAR;

use App\Core\Container\Container;

class AbstractTable
{
    protected string $table;
    protected array $fields;

    public function run()
    {
        /** @var RunSQLScript $script */
        $script = Container::call(RunSQLScript::class);
        $script->runSQL($this);
    }


}