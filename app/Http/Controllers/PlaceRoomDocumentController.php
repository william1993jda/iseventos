<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceRoomDocumentRequest;
use App\Models\Place;
use App\Models\PlaceRoomDocument;
use App\Models\PlaceRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaceRoomDocumentController extends Controller
{
    public function index(Place $place, PlaceRoom $room)
    {
        $documents = $room->documents()->orderBy('name', 'ASC')->paginate(10);

        return view('places.rooms.documents.index', compact('room', 'documents'));
    }

    public function create(Place $place, PlaceRoom $room)
    {
        $document = new PlaceRoomDocument();

        return view('places.rooms.documents.form', compact('room', 'document'));
    }

    public function store(Place $place, PlaceRoom $room, PlaceRoomDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'places/rooms/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $room->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('places.rooms.documents.index', [$place->id, $room->id]);
    }

    public function edit(PlaceRoom $placeRoom, PlaceRoomDocument $document, $showMode = false)
    {
        return view('places.rooms.documents.form', compact('placeRoom', 'document', 'showMode'));
    }

    public function update(PlaceRoom $placeRoom, PlaceRoomDocument $document, PlaceRoomDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('places.rooms.documents.index', $placeRoom->id);
    }

    public function destroy($place, $placeRoom, $document)
    {
        $document = PlaceRoomDocument::findOrFail($document);
        $document->delete();

        return redirect()->route('places.rooms.documents.index', [$place, $placeRoom]);
    }

    public function show(PlaceRoom $placeRoom, PlaceRoomDocument $document)
    {
        return $this->edit($placeRoom, $document, true);
    }
}
