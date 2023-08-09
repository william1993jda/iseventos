<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlaceDocumentRequest;
use App\Models\Place;
use App\Models\PlaceDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlaceDocumentController extends Controller
{
    public function index(Place $place)
    {
        $documents = $place->documents()->orderBy('name', 'ASC')->paginate(10);

        return view('places.documents.index', compact('place', 'documents'));
    }

    public function create(Place $place)
    {
        $document = new PlaceDocument();

        return view('places.documents.form', compact('place', 'document'));
    }

    public function store(Place $place, PlaceDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'places/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $place->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('places.documents.index', $place->id);
    }

    public function edit(Place $place, PlaceDocument $document, $showMode = false)
    {
        return view('places.documents.form', compact('place', 'document', 'showMode'));
    }

    public function update(Place $place, PlaceDocument $document, PlaceDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('places.documents.index', $place->id);
    }

    public function destroy(Place $place, PlaceDocument $document)
    {
        $document->delete();

        return redirect()->route('places.documents.index', $place->id);
    }

    public function show(Place $place, PlaceDocument $document)
    {
        return $this->edit($place, $document, true);
    }
}
