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

class Internal implements Caching\Interfaces\Engine
{

    private $data = array();

    public function fetch($key)
    {
        if (!isset($this->data[$key])) {
            return Promises\When::reject($key);
        }
        return Promises\When::resolve($this->data[$key]);
    }

    public function store($key, $value)
    {
        $this->data[$key] = $value;
        return Promises\When::resolve($value);
    }

    public function delete($pattern)
    {
        foreach (preg_grep($pattern, array_keys($this->data)) as $key) {
            unset($this->data[$key]);
        }
        return Promises\When::resolve($pattern);
    }

    public function clear()
    {
        $this->data = array();
        return Promises\When::resolve();
    }
}
