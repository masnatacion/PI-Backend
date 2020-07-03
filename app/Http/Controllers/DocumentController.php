<?php

namespace App\Http\Controllers;


use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

use File;
use Response;
use App\Entities\User;
use App\Entities\Document;

class DocumentController extends ApiController
{

    public function index(User $user)
    {
        return $this->ok($user->documents()->paginate());
    }

    public function cv(User $user)
    {
        if(!$user->cv)
            return $this->not_found();

        return response()->download($user->cv->path, $user->cv->filename);
    }

    public function download(Document $document)
    {
        if(!$document->path)
            return $this->not_found();

        return response()->download($document->path, $document->filename);
    }

    public function picture(User $user)
    {
        if(!$user->picture)
            return $this->not_found();

        if (!File::exists($user->picture->path)) {
            abort(404);
        }
        $file = File::get($user->picture->path);
        $type = File::mimeType($user->picture->path);
        $data = Response::make($file, 200);
        $data->header("Content-Type", $type);

        return $data;
    }

    public function store_update_picture(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'file'  => 'required|mimes:jpg,jpeg|max:20048',
        ]);

        if ($validator->fails())
            return $this->bad_request($validator->errors());

        $document = $user->attachPicture($request->file('file'));

        return $this->created($document);
    }

    public function store_update_cv(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'file'  => 'required|mimes:pdf|max:20048',
        ]);

        if ($validator->fails())
            return $this->bad_request($validator->errors());

        $document = $user->attachCV($request->file('file'));

        return $this->created($document);
    }


    public function destroy_picture(User $user)
    {
        $is_deleted = $user->picture()->delete();
        if($is_deleted)
            return $this->deleted();

        return $this->not_found();
    }

    public function destroy_cv(User $user)
    {
        $is_deleted = $user->cv()->delete();
        if($is_deleted)
            return $this->deleted();

        return $this->not_found();
    }
}
