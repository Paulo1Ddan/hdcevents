<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    //Rota Index
    public function index(){

        $search = request('search');

        if($search){

            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();

        }else{

            $events = Event::all();
        }


        return view('welcome', [
            'events' => $events,
            'search' => $search
        ]);
    }

    // Rota Create
    public function create(){
        return view("events.create");
    }

    // Rota POST Store
    public function store(Request $request){
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        $user = auth()->user();
        $event->user_id = $user->id;

        // Image Upload
        // Verificando se há o arquivo
        if($request->hasFile('image') && $request->file('image')->isValid()){
            //Encapsulando Imagem
            $image = $request->image;
            //Pegando Extensão
            $ext = $image->extension();
            //Definindo nome da imagem
            $imgname = md5($image->getClientOriginalName().strtotime('now')).".".$ext;
            //Salvando a imagem na pasta
            $image->move(public_path('img/events'), $imgname);

            $event->image = $imgname;

        }

        $event->save();

        return redirect('/')->with('msg', "Evento Criado com sucesso!");

    }

    // Rota Show
    public function show($id){
        $event = Event::findOrFail($id);

        $user = auth()->user();

        $hasUserJoined = false;

        if($user){

            $userEvents = $user->eventAsParticipant->toArray();

            foreach($userEvents as $userEvent){
                if($userEvent['id'] == $id){
                    $hasUserJoined = true;
                }
            }

        }

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, "hasUserJoined" => $hasUserJoined]);
    }

    // Rota Dashboard
    public function dashboard(){
        $user = auth()->user();

        //Model User
        $events = $user->events;

        $eventsAsParticipant = $user->eventAsParticipant;

        return view('events.dashboard', ['events' => $events, "eventsAsParticipant" => $eventsAsParticipant]);
    }

    // Rota Destroy
    public function destroy($id){
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');

    }

    // Rota Edit
    public function edit($id){

        $user = auth()->user();


        $event = Event::findOrFail($id);

        if($user->id != $event->user->id){
            return redirect('/dashboard')->with("msg", 'Você não tem permissão para acessar essa pagina');
        }


        return view('events.edit', ['event' => $event]);
    }

    // Rota Update
    public function update(Request $request){
        $event = Event::findOrFail($request->id);
        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            unlink(public_path('img/events/' . $event->image));
            $requestImage = $request->image;
            $extension = $requestImage->extension();
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            $requestImage->move(public_path('img/events'), $imageName);
            $data['image'] = $imageName;
        }
        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }

    // Rota Join
    public function joinEvent($idevent){
        $user = auth()->user();

        $user->eventAsParticipant()->attach($idevent);

        $event = Event::findOrFail($idevent);

        return redirect('/dashboard')->with("msg", "Sua presença está confirmada no evento: ". $event->title);
    }

    public function leaveEvent($idevent){
        $user = auth()->user();

        $user->eventAsParticipant()->detach($idevent);

        $event = Event::findOrFail($idevent);

        return redirect('/dashboard')->with("msg", "Você saiu do evento: ". $event->title);
    }
}
