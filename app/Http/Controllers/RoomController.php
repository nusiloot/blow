<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Room;

class RoomController extends Controller{

  public function show(){
      $rooms = Room::all();
      return $rooms->toJson();
  }

  public function create(Request $request){
        $request->validate([
        'room_name' => 'required',
        'capacity' => 'integer',  //ajouter la validation de l'image
        ]);

       $room = new Room;
       $room->title = $request->room_name;
       $room->equipment = $request->equipment;
       $room->capacity = $request->capacity;
       $room->eventColor = $request->eventColor;
       $room->image=$request->image;
       $room->save();

      // Mame : essai réussi insertion d'image
      // $image = $request->file('image')->store('images');
      // Storage::disk('public')->put($image, 'Contents');
     // $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
     // $destinationPath = public_path('/thumbnail');
     // $img = Image::make($image->getRealPath());
     // $img->resize(100, 100, function ($constraint) {
     //     $constraint->aspectRatio();
     // })->save($destinationPath.'/'.$input['imagename']);

     // /*After Resize Add this Code to Upload Image*/
     // $destinationPath = public_path('/');
     // $image->move($destinationPath, $input['imagename']);
      return redirect('/')->with('success', 'La salle a bien été ajouté');
  }

  public function update(Request $request){

    $roomId = $request->room_id;

    if($roomId!=null){
       $room = Room::find($room_id);
       $room->title = $request->room_name;
       $room->equipment=$request->equipment;
       $room->capacity=$request->capacity;
       $room->eventColor=$request->eventColor;
       $room->image=$request->image;
       $room->save();

        return redirect()->back()->with('success', 'La salle a bien été modfié');
    }

      return redirect()->back()->with('error', 'La salle n\'a pas été identifée');

  }
  public function delete(Request $request,$id){
         $room = Room::find($id)->delete();
             return redirect('/')->with('success', 'Votre salle a bien été supprimé');
   }

}
