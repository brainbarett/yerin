<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Admin\ImagesResource;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImagesController extends Controller
{
    public function upload(Request $request)
    {
        $data = $request->validate([
            'file' => ['required', 'mimes:jpeg,jpg,png', 'max:2000'],
        ]);

        $image = DB::transaction(function () use ($data) {
            $image = Images::create([
                'filename' => $data['file']->getClientOriginalName(),
            ]);

            $image->associateFile($data['file']);

            return $image;
        });

        return ImagesResource::make($image);
    }
}
