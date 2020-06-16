<?php

namespace App\Http\Controllers;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventController extends Controller
{
    public function list(){
      $events = Event::all();
      return view('index', [
          'events' => $events
        ]);
    }

    public function listTest(){
      //$events = Evenement::all();
      $events = DB::table('events')->select('id','title', 'start','resourceId','end')->get();
      return response(json_encode($events), 200)->header('Content-Type', 'application/json');
      }

    public function insertEvent(Request $request){

      $nom = $request->input('event_name');
      $start = $request->input('start_date').'T'.$request->input('start_hour').'Z';
      $end= $request->input('end_date').'T'.$request->input('end_hour').'Z';
      $resource = $request->input('room_id');

      echo "<script>alert(".$start.")</script>";
      echo "<script>alert(".$end.")</script>";

      if ($start< Carbon::now()){
        echo"<script>alert('créneau déjà passé');</script>";
        return redirect()->to(url()->previous() . '#reserver');
      }


      $query = DB::table('events')
          ->where('resourceId','=',$resource)
          ->where('start','=',$start)
          ->orWhere('start','<',$start)
          ->where('end','=',$end)
          ->orWhere('end','>',$end)
          ->count();
      echo($query);

      if($query>0){
      echo"<script>alert('Créneau déjà réservé pour cette salle');</script>";
         return redirect()->to(url()->previous() . '#reserver');
        }

      $data=array('title'=>$nom,'start'=>$start,"end"=>$end,"resourceId"=>$resource);
      DB::table('events')->insert($data);
      echo "<script>alert('Inseré avec succès');</script>";
        return redirect()->to(url()->previous() . '#reserver');
      }


      public function updateEvent(Request $request, $idEvent){

        $start=$request->input('start_date');
        $end=$request->input('end_date');
        $startTime=$request->input('start_hour');
        $endTime=$request->input('end_hour');

        $title = $request->input('event_name');
        //POUR SIDI VOILA LID DE L' EVENT
        $eventID = $request->input('event_id');
        //
        $start = $request->input('start_date').'T'.$request->input('start_hour').'Z';
        $end= $request->input('end_date').'T'.$request->input('end_hour').'Z';
        $resourceId = $request->input('resourceId');

        $data = array('title'=>$title,'start'=>$start,"end"=>$end,"resourceId"=>$resource);
        $status =  DB::table('events')
        ->where('id', $idEven)
        ->update($data);
        return response()->json(array('success' => $status, 'data' => $data, 'message' => 'Evenement à bien été mise ajour'));

      }

  }

?>
