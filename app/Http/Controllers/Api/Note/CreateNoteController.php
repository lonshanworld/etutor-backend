<?php

namespace App\Http\Controllers\Api\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateNoteController extends Controller
{
    public function __invoke(StoreNoteRequest $storeNoteRequest)
    {
        DB::beginTransaction();
        try {
            $validatedData = $storeNoteRequest->validated();
            $validatedData['url_link'] = [];
            
            if ($storeNoteRequest->hasFile('attachments')) {
                $createdNote = auth('sanctum')->user()->notes()->create($validatedData);

                foreach ($storeNoteRequest->validated('attachments') as $attachment) {
                    $path = $attachment->store('etuto/users/' . auth('sanctum')->user()->id . '/notes/attchments', 's3');
                    $createdNote->files()->create([
                        'url_link' => Storage::disk('s3')->url($path)
                    ]);
                }
            }

            DB::commit();
            return response()->success();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('store note api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}