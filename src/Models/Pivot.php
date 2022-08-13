<?php

namespace Armincms\Coursera\Models;

use Armincms\Contract\Concerns\Configurable;
use Illuminate\Database\Eloquent\Relations\Pivot as LaravelPivot;

class Pivot extends LaravelPivot
{
    use Configurable;
}
