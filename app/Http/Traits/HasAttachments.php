<?php

namespace App\Http\Traits;

trait HasAttachments
{
    /**
     * Get all of the model's attachments.
     */
    public function attachments()
    {
        return $this->morphMany('App\Models\Attachment', 'attachable');
    }
}

