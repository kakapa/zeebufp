<?php

if (! function_exists('setting')) {
    /**
     * Echo out the value of a Setting key.
     *
     * @param  string  $delimiter
     * @return mixed|null
     */
    function setting(string $key, $default = null, $delimiter = ',')
    {
        return \App\Models\Setting::valueForKey($key);
    }
}
