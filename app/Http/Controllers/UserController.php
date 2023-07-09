<?php

namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\User;
use App\Images;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        # Middleware
         $this->middleware('auth');
    }

    public function Show($pi_id){
        $user = User::find($pi_id);

        if($user){
            return response()->json([
                'success' => true,
                'message' => 'User ditemukan!',
                'data' => $user
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function UploadImage(Request $request){
        # Validasi file yang terupload
        $this->validate($request, [
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            # Generate nama untuk file
            $fileName = time() . '_' . $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $fileSize = $file->getClientSize();

            $raw_apiToken = explode(' ', $request->header('Authorization'));
            $apiToken = $raw_apiToken[1];

            $user = User::where('api_token', $apiToken)->first();

            if ($user == NULL) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan!',
                    'data' => ''
                ], 404);
            }

            $data = [
                'filename' => $fileName,
                'type_file' => $fileExtension,
                'size_file' => $fileSize,
                'description' => 'Images from '.$user['id'].' '.explode('_', $fileName)[0],
                'user_id' => $user['id']
            ];
            
            try {
                if (Images::create($data)) {
                    # Memindahkan file ke folder tertentu
                    $file->move(base_path('\public\images'), $fileName);

                    # Return jika berhasil
                    return response()->json([
                        'success' => true,
                        'message' => 'File terupload dengan sukses',
                    ], 200);
                }
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error ketika upload file. Err : '.$e,
                ], 400);
            }
        }

        # Return jika tidak ada file yang di upload
        return response()->json([
                'success' => false,
                'message' => 'Tidak ada file yang di upload',
            ], 400);
    }

    //
}
