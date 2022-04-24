<?php

namespace Armincms\Blogger\Policies;

use Armincms\Contract\Policies\Policy;
use Armincms\Contract\Policies\SoftDeletes;

class Lesson extends Policy
{ 
    use SoftDeletes; 
}
