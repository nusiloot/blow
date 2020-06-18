<?php

namespace App\Http\Controllers;
use App\Event;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
// use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function showEvents(){
      $events = Event::all();
      return view('index', [
          'events' => $events
        ]);
    }

    public function createEventsJson(){
      $events = DB::table('events')->select('id','title', 'start','resourceId','end')->get();
      return response(json_encode($events), 200)->header('Content-Type', 'application/json');
      }

          public function insertEvent(Request $request){

            $nom = $request->input('event_name');
            $start = $request->input('start_date').'T'.$request->input('start_hour').'Z';
            $end= $request->input('end_date').'T'.$request->input('end_hour').'Z';
            $resource = $request->input('room_id');

            $start_date = $request->input('start_date').$request->input('start_hour');
            $date = Carbon::now('Europe/Paris')->format('Y-m-dH:i:s');
            $current_user= Auth::user()->id;



            echo "<script>alert(".$start.")</script>";
            echo "<script>alert(".$end.")</script>";

            date_default_timezone_set('Europe/Paris');

             echo($date);
             echo($start_date);



              if ($start_date < $date){ //si la date et l'heure sont déjà je ne peux pas réserver
              return redirect()->to(url()->previous() . '#reserver')->with('failPassed',
              'Pour l\'instant, on ne peut pas remonter dans le temps, désolé :(');;
            }

            //Vérifier qu'il n'y a pas déjà un événement dans l'interval du créneau soufaité.
            $query =DB::select('select * from events where resourceId =:resource and ( (start <=:start and end >=:end) or (start >=:start and end<=:end))',
            ['resource'=>$resource,'start' => $start, 'end' => $end]);

            // echo(count($query));
            if(count($query)>0){
                 return redirect()->to(url()->previous() . '#reserver')->with('failUnavailable',
                 'Votre événement n\'a pas été ajouté car le créneau est déja réservé pour cette salle');
              }

            $data=array('title'=>$nom,'start'=>$start,"end"=>$end,"resourceId"=>$resource,"user_id"=>$current_user);
            DB::table('events')->insert($data);
              return redirect()->to(url()->previous() . '#reserver')->with('success',
              'Votre événement a été ajouté, vous pouvez désormais envoyez un lien de partage');

            }

            //modifier un evenement
            public function updateEvent(Request $request, $eventID){


                $title = $request->input('event_name');
                $start = $request->input('start_date').'T'.$request->input('start_hour').'Z';
                $end= $request->input('end_date').'T'.$request->input('end_hour').'Z';
                $resource = $request->input('room_id');
                 $start_date = $request->input('start_date').$request->input('start_hour');
                 $date = Carbon::now('Europe/Paris')->format('Y-m-dH:i:s');

                 if ($start_date < $date){     //si la date et l'heure sont déjà je ne peux pas modifier
                 return redirect()->to(url()->previous() . '#reserver')->with('failPassed',
                 'Pour l\'instant, on ne peut pas remonter dans le temps, désolé :(');;
                 }


                 //Vérifier qu'il n'y a pas déjà un événement dans l'interval du créneau soufaité.
                $query =DB::select('select * from events where resourceId =:resource and ( (start <=:start and end >=:end) or (start >=:start and end<=:end))',
                ['resource'=>$resource,'start' => $start, 'end' => $end]);


                // echo(count($query));
                if(count($query)>0){
                echo"<script>alert('Créneau déjà réservé pour cette salle');</script>";
                     return redirect()->to(url()->previous() . '#reserver');
                }

                $data = array('title'=>$title,'start'=>$start,'end'=>$end);
                $status =  DB::table('events')
                ->where('id', $eventID)
                ->update($data);

                echo "<script>alert('Inseré avec succès');</script>";
                 return redirect()->to(url()->previous() . '#reserver');

            }

           //supprimer un événement

            public function deleteEvent(Request $request, $idEvent){


              $status = Event::find($idEvent)->delete();

              return response()->json(array('success' => $status, 'message' => 'Evenement has been delated'));


           }


  }

?>
