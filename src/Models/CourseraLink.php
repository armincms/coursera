<?php

namespace Armincms\Coursera\Models;
 
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes; 

class CourseraLink extends Model
{   
    use SoftDeletes;    
    
    /**
     * Query related CourseraLesson.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(CourseraLesson::class);
    }    
    
    /**
     * Query related CourseraServer.
     * 
     * @return \Illuminate\Database\Eloquent\Relatinos\BelongsTo
     */
    public function server()
    {
        return $this->belongsTo(CourseraServer::class);
    }    

    /**
     * Get the available video resolutions.
     * 
     * @return array
     */
    public static function resolutions()
    {
        return [
            '640x480' => __('SD [480p - 4:3]'),
            '1280x720' => __('HD [720p - 16:9]'),
            '1920x1080' => __('FHD [1080p - 16:9]'),
            '2560x1440' => __('QHD [1440p - 16:9]'), 
            '2048x1080' => __('2K [1080p - 1:1.77]'),
            '3840x2160' => __('4K [UHD - 1:1.9]'),
            '7680x4320' => __('8K [FUHD - 1:1.77]'),
        ];
    }       
}
