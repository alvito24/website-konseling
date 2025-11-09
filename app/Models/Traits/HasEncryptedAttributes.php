<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Crypt;

trait HasEncryptedAttributes
{
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        if (in_array($key, $this->encrypted ?? [])) {
            try {
                return $value ? Crypt::decryptString($value) : null;
            } catch (\Exception $e) {
                return $value;
            }
        }
        
        return $value;
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encrypted ?? [])) {
            $value = $value ? Crypt::encryptString($value) : null;
        }

        return parent::setAttribute($key, $value);
    }
}