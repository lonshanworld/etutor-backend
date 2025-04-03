<?php

namespace App\Http\Controllers\Api\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Resources\Api\NoteResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateNoteController extends Controller
{
    public function __invoke(StoreNoteRequest $storeNoteRequest)
    {
        try {
            DB::beginTransaction();
            $validatedData = $storeNoteRequest->validated();
            $validatedData['url_link'] = [];
            if ($storeNoteRequest->has('attachments')) {
                $createdNote = auth('sanctum')->user()->notes()->create($validatedData);
                foreach ($storeNoteRequest->validated('attachments') as $attachment) {
                    $createdNote->files()->create([
                        'file_name' => $attachment['name'],
                        'url_link' => $attachment['path']
                    ]);
                }
            }
            DB::commit();
            $refreshNote = $createdNote->refresh();
            return response()->success([
                'note' => new NoteResource($refreshNote->load('files'))
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info('store note api', [
                'message' => $th->getMessage()
            ]);
            return response()->error();
        }
    }
}
