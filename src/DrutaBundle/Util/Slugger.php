<?php

namespace DrutaBundle\Util;

class Slugger
{
    public static function getSlug($name, $separator = '-')
    {
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = strtolower(trim($slug, $separator));
        $slug = preg_replace("/[\/_|+ -]+/", $separator, $slug);
        return $slug;
    }
}