<?php

namespace Armincms\Blogger\Policies;

use Armincms\Contract\Policies\Policy;
use Armincms\Contract\Policies\SoftDeletes;

class Episode extends Policy
{ 
    use SoftDeletes; 
}
