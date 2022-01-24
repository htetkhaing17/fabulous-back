<?php

namespace App\Http\Controllers;

use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class UploadFileController extends Controller
{
    private $cloudinary;
    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_NAME'),
                    'api_key'    => env('CLOUDINARY_KEY'),
                    'api_secret' => env('CLOUDINARY_SECRETE'),
                ],                
            ]
        );
    }

    public function tmpUpload(Request $request)
    {

        return $this->cloudinary->uploadApi()->upload($request->file('file')->getRealPath(), array('folder'=>'fabulous-lives/_temp'));
        // return $request->file('file')->storeAs('products', time().'.'.$request->file('file')->extension());
    }
}
