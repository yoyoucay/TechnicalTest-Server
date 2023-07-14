<?php

namespace App\Http\Controllers;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Room;
use App\Images;

class RoomController extends Controller
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

    public function ShowAll(){
        $room = Room::join('images','rooms.image_id','=','images.id')
            ->select('rooms.*', 'images.filename')
            ->get();

        if($room){
            $pathimg = '\public\images'.$room[0]->filename;
            $room[0]['urlToImage'] = URL::to($pathimg);
            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan!',
                'data' => $room
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan!',
                'data' => ''
            ], 404);
        }        
    }

    public function ShowDetail($room_id){
        $room = Room::find($room_id);
        if($room){
            return response()->json([
                'success' => true,
                'message' => 'Room ditemukan!',
                'data' => $room
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Room tidak ditemukan!',
                'data' => ''
            ], 404);
        }
    }

    public function Create(Request $request){

        #Pengambilan
        $name_room = $request->input('name_room');
        $maxperson = $request->input('maxperson');
        $price = $request->input('price');
        $stock = $request->input('stock');

        $image_id = $this->UploadImage($request);

        $createRoom = Room::create([
            'name_room' => $name_room,
            'maxperson' => $maxperson,
            'price' => $price,
            'stock' => $stock,
            'image_id' => $image_id
        ]);

        if ($createRoom) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil membuat Room!',
                'data' => $createRoom
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Room!',
                'data' => $createRoom
            ], 400);
        }
    }

    function Update(Request $request){
       
        $data = $request->all();

        $dataM = Room::find($data['id_room']);

        if ($dataM) {
            $dataM->name_room = $data['name_room'];
            $dataM->maxperson = $data['maxperson'];
            $dataM->price = $data['price'];
            $dataM->stock = $data['stock'];
            $dataM->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data Room!',
                'data' => $dataM
            ], 201);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data Room!',
                'data' => $dataM
            ], 400);
        }
    }

    function Remove(Request $request){
        $data = $request->all(); 
        
        $dataM = Room::find($data['id_room']);

        if ($dataM) {
            $dataM->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data Room!',
                'data' => $dataM
            ], 201);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data Room!',
                'data' => $dataM
            ], 400);
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
                if ($model = Images::create($data)) {
                    # Memindahkan file ke folder tertentu
                    $file->move(base_path('\public\images'), $fileName);

                    # Return jika berhasil
                    return $model->id;
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
