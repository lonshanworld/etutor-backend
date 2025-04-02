<?php

namespace App\Http\Requests\Attachment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreAttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attachments' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $totalSize = 0;
                    $files = $this->file('attachments');
                    
                    if (!is_array($files)) {
                        return;
                    }
                    
                    foreach ($files as $file) {
                        if ($file && $file->isValid()) {
                            $totalSize += $file->getSize();
                        }
                    }

                    $maxSize = 50 * 1024 * 1024;
                    
                    if ($totalSize > $maxSize) {
                        $fail('The total size of all attachments must not exceed 50MB.');
                    }
                }
            ],
            'attachments.*' => 'file|max:4096'
        ];
    }
}
