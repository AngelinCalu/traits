<?php

namespace App\Http\Traits;

use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;


trait HasAttachments
{
    /**
     * Get all of the model's attachments.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }


    /**
     * Create new attachments for the current model.
     * @param $file
     * @param $company_id (optional)
     */
    public function attach($file, $company_id = null)
    {

            $attach = new Attachment();
            $attach->attachable_id = $this->id;
            $attach->attachable_type = get_class($this);
            $attach->original_filename = $file->getClientOriginalName();
            $store_path = $this->table. '/' . ($company_id ?? Auth::id());
            $attach->filename = $file->store($store_path);
            $attach->type = $file->getMimeType();
            $attach->size = $file->getSize();

            $attach->save();

            return $attach;

    }
}

