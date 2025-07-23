<?php

namespace App\Traits;

use App\Models\EncryptedData;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Encryptable
{
    /**
     * Boot the trait.
     */
    protected static function bootEncryptable()
    {
        static::saving(function ($model) {
            $model->encryptFields();
        });

        static::saved(function ($model) {
            $model->saveEncryptedFields();
        });

        static::deleting(function ($model) {
            $model->encryptedData()->delete();
        });
    }

    /**
     * Define the relationship with encrypted data.
     */
    public function encryptedData(): MorphMany
    {
        return $this->morphMany(EncryptedData::class, 'model');
    }

    /**
     * Get the fields that should be encrypted.
     */
    public function getEncryptableFields(): array
    {
        return $this->encryptable ?? [];
    }

    /**
     * Encrypt fields before saving the model.
     */
    protected function encryptFields()
    {
        foreach ($this->getEncryptableFields() as $field) {
            if (isset($this->attributes[$field]) && !empty($this->attributes[$field])) {
                $this->encryptedValues[$field] = $this->attributes[$field];
                unset($this->attributes[$field]);
            }
        }
    }

    /**
     * Save encrypted fields to the encrypted_data table.
     */
    protected function saveEncryptedFields()
    {
        if (!empty($this->encryptedValues)) {
            foreach ($this->encryptedValues as $field => $value) {
                $encryptedData = $this->encryptedData()->updateOrCreate(
                    ['field_name' => $field],
                    ['encrypted_value' => Crypt::encrypt($value)]
                );
            }
            $this->encryptedValues = [];
        }
    }

    /**
     * Get an attribute from the model.
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if ($value === null && in_array($key, $this->getEncryptableFields())) {
            $encryptedData = $this->encryptedData()->where('field_name', $key)->first();
            if ($encryptedData) {
                return Crypt::decrypt($encryptedData->encrypted_value);
            }
        }

        return $value;
    }
}