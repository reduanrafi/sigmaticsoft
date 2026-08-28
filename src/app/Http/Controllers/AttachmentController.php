<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttachmentController extends Controller
{
    use AuthorizesRequests;

    public function download(Attachment $attachment)
    {
        $this->authorize('view', $attachment);

        if (!Storage::exists($attachment->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::download($attachment->file_path, $attachment->file_name);
    }

    public function destroy(Attachment $attachment)
    {
        $this->authorize('delete', $attachment);

        if (Storage::exists($attachment->file_path)) {
            Storage::delete($attachment->file_path);
        }

        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully.');
    }
}
