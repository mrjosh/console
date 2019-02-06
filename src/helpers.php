<?php

if(! function_exists("package_path")){

    /**
     * Get package path
     *
     * @author Alireza Josheghani <josheghani.dev@gmail.com>
     * @since 31 Jan 2019
     * @param null $path
     * @return string
     */
    function package_path($path = null)
    {
        if(empty($_SERVER['HOME'])){
            return posix_getpwuid(posix_getuid()) . "/.Josh/" . ( is_null($path) ?: $path );
        }

        return $_SERVER['HOME'] . "/.Josh/" . ( is_null($path) ?: $path );
    }
}