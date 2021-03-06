<?php
/**
 * Bread PHP Framework (http://github.com/saiv/Bread)
 * Copyright 2010-2012, SAIV Development Team <development@saiv.it>
 *
 * Licensed under a Creative Commons Attribution 3.0 Unported License.
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright  Copyright 2010-2012, SAIV Development Team <development@saiv.it>
 * @link       http://github.com/saiv/Bread Bread PHP Framework
 * @package    Bread
 * @since      Bread PHP Framework
 * @license    http://creativecommons.org/licenses/by/3.0/
 */
namespace Bread\Caching\Engines;

use Bread\Caching;
use Bread\Promises;
use APCIterator;

class APC implements Caching\Interfaces\Engine
{

    public function fetch($key)
    {
        $result = apcu_fetch($key, $success);
        if (!$success) {
            return Promises\When::reject($key);
        }
        return Promises\When::resolve($result);
    }

    public function store($key, $var)
    {
        return apcu_store($key, $var) ? Promises\When::resolve($var) : Promises\When::reject($key);
    }

    public function delete($pattern)
    {
        $iterator = new APCIterator($pattern, APC_ITER_VALUE);
        return apcu_delete($iterator) ? Promises\When::resolve($pattern) : Promises\When::reject($pattern);
    }

    public function clear()
    {
        return apcu_clear_cache() ? Promises\When::resolve() : Promises\When::reject();
    }

    public function info()
    {
        return apcu_cache_info();
    }
}
