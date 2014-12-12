<?php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function boot()
    {
        $doctrine = $this->container->get('doctrine');

        $doctrine->getManager()->getConfiguration()->addFilter(
            'soft-deleteable',
            'Gedmo\SoftDeleteable\Filter\SoftDeleteableFilter'
        );

        $em = $doctrine->getManager();

        $em->getFilters()->enable('soft-deleteable');
    }
}
