<?php

/**
 *  Echo's the provided css $class if the current route is matched.
 *
 * @param string $route
 * @param string $class
 */
function setActiveNav($route, $class)
{
    if ($route != '/') {
        $route = trim(trim($route), '/');
    }

    if (request()->is($route)) {
        echo $class;
    }
}

/**
 * $data coresponds to a model that gets filtered and
 * it returns only the specified keys.
 *
 * They keys apply to relational models too (in-depth).
 *
 * @param array $data
 * @param array $keys
 *
 * @return array
 */
function filterModelKeys(array $data, array $keys)
{
    $only = array_flip($keys);

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $data[$key] = filterModelKeys($value, $keys);
            continue;
        }

        if (!isset($only[$key])) {
            unset($data[$key]);
        }
    }

    return $data;
}

/**
 * @return string
 */
function refererUtil()
{
    return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'n/a';
}

/**
 * @return string
 */
function ipUtil()
{
    return (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : 'n/a';
}
