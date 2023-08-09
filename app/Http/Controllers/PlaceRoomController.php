<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceRoomRequest;
use App\Models\Place;
use App\Models\PlaceRoom;

class PlaceRoomController extends Controller
{
    public function index(Place $place)
    {
        $rooms = $place->rooms()->orderBy('name', 'ASC')->paginate(10);

        return view('places.rooms.index', compact('place', 'rooms'));
    }

    public function create(Place $place)
    {
        $room = new PlaceRoom();

        return view('places.rooms.form', compact('place', 'room'));
    }

    public function store(Place $place, PlaceRoomRequest $request)
    {
        $params = $request->validated();

        $params['active'] = $request->has('active');

        $place->rooms()->create($params);

        return redirect()->route('places.rooms.index', $place->id);
    }

    public function edit(Place $place, PlaceRoom $room, $showMode = false)
    {
        return view('places.rooms.form', compact('place', 'room', 'showMode'));
    }

    public function update(Place $place, PlaceRoom $room, PlaceRoomRequest $request)
    {
        $params = $request->validated();

        $params['active'] = $request->has('active');

        $room->update($params);

        return redirect()->route('places.rooms.index', $place->id);
    }

    public function destroy(Place $place, PlaceRoom $room)
    {
        $room->delete();

        return redirect()->route('places.rooms.index', $place->id);
    }

    public function show(Place $place, PlaceRoom $room)
    {
        return $this->edit($place, $room, true);
    }
}
