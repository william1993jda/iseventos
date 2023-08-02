<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceRequest;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $query = $request->get('query');

        if ($query) {
            $places = Place::where('name', 'like', '%' . $query . '%')
                ->orderBy('name', 'ASC')
                ->paginate(10);

            return view('places.index', compact('places', 'query'));
        }

        $places = Place::orderBy('name', 'ASC')->paginate(10);

        return view('places.index', compact('places', 'query'));
    }

    public function create()
    {
        $place = new Place();
        $states = Place::STATES;

        return view('places.form', compact('place', 'states'));
    }

    public function store(PlaceRequest $request)
    {
        Place::create($request->validated());

        return redirect()->route('places.index');
    }

    public function edit(Place $place, $showMode = false)
    {
        $states = Place::STATES;

        return view('places.form', compact('place', 'states', 'showMode'));
    }

    public function update(Place $place, PlaceRequest $request)
    {
        $place->update($request->validated());

        return redirect()->route('places.index');
    }

    public function destroy(Place $place)
    {
        $place->rooms()->get()->each(function ($room) {
            $room->documents()->delete();
        });

        $place->rooms()->delete();
        $place->documents()->delete();
        $place->delete();

        return redirect()->route('places.index');
    }

    public function show(Place $place)
    {
        return $this->edit($place, true);
    }
}
