<?php
/**
 * Created by PhpStorm.
 * User: sachin
 * Date: 4/20/17
 * Time: 10:47 AM
 */

namespace App\Traits;

trait EventCallbackTrait
{
    // stub creating event callback function
    public function creating_event(){
        return true;
    }

    // stub created event callback function
    public function created_event(){
        return true;
    }

    // stub updating event callback function
    public function updating_event(){
        return true;
    }

    // stub updated event callback function
    public function updated_event(){
        return true;
    }

    // stub saving event callback function
    public function saving_event(){
        return true;
    }

    // stub saved event callback function
    public function saved_event(){
        return true;
    }

    // stub deleting event callback function
    public function deleting_event(){
        return true;
    }

    // stub deleted event callback function
    public function deleted_event(){
        return true;
    }

    // stub restoring event callback function
    public function restoring_event(){
        return true;
    }

    // stub restored event callback function
    public function restored_event(){
        return true;
    }
}