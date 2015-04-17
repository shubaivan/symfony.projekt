<?php

namespace AppBundle\Twig;

class AppBundleExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('hashTag', array($this, 'addHashTag')),
        );
    }

    public function addHashTag($text)
    {
        return '#'.$text;
    }

    public function getName()
    {
        return "appbundle_extension";
    }
}
