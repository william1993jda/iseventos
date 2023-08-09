<?php

namespace App\Http\Controllers;

use App\Http\Requests\FreelancerDocumentRequest;
use App\Models\Freelancer;
use App\Models\FreelancerDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FreelancerDocumentController extends Controller
{
    public function index(Freelancer $freelancer)
    {
        $documents = $freelancer->documents()->orderBy('name', 'ASC')->paginate(10);

        return view('freelancers.documents.index', compact('freelancer', 'documents'));
    }

    public function create(Freelancer $freelancer)
    {
        $document = new FreelancerDocument();

        return view('freelancers.documents.form', compact('freelancer', 'document'));
    }

    public function store(Freelancer $freelancer, FreelancerDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'freelancers/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $freelancer->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('freelancers.documents.index', $freelancer->id);
    }

    public function edit(Freelancer $freelancer, FreelancerDocument $document, $showMode = false)
    {
        return view('freelancers.documents.form', compact('freelancer', 'document', 'showMode'));
    }

    public function update(Freelancer $freelancer, FreelancerDocument $document, FreelancerDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('freelancers.documents.index', $freelancer->id);
    }

    public function destroy(Freelancer $freelancer, FreelancerDocument $document)
    {
        $document->delete();

        return redirect()->route('freelancers.documents.index', $freelancer->id);
    }

    public function show(Freelancer $freelancer, FreelancerDocument $document)
    {
        return $this->edit($freelancer, $document, true);
    }
}
