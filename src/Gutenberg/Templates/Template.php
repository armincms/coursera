<?php

namespace Armincms\Coursera\Gutenberg\Templates; 

use Zareismail\Gutenberg\Template as GutenbergTemplate;  

abstract class Template extends GutenbergTemplate 
{       
     /**
     * The logical group associated with the template.
     *
     * @var string
     */
    public static $group = 'Coursera'; 
}
