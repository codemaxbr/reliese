<?php

/**
 * Created by Cristian.
 * Date: 02/10/16 11:06 PM.
 */

namespace Codemax\Meta;

interface Column
{
    /**
     * @return \Illuminate\Support\Fluent
     */
    public function normalize();
}
