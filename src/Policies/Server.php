<?php

namespace Armincms\Blogger\Policies;

use Armincms\Contract\Policies\Policy;
use Armincms\Contract\Policies\SoftDeletes;

class Server extends Policy
{ 
    use SoftDeletes; 
}
