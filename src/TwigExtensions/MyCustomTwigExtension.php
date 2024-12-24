<?php

namespace App\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyCustomTwigExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
          new TwigFilter('defaultImage',
              [$this, 'defaultImage']
          ),
        ];
    }

    public function defaultImage(string $image) : string
    {
        if (strlen(trim($image)) === 0)
        {
            return 'java.png';
        }
        return $image;
    }
}