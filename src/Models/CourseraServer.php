<?php

namespace Armincms\Coursera\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CourseraServer extends Model
{   
    use SoftDeletes;    
    
    /**
     * Query related CourseraServer.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\HasOneOrMany
     */
    public function links()
    {
        return $this->hasMany(CourseraLink::class, 'server_id');
    }    
}
