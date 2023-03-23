<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetDocumentRequest;
use App\Models\Budget;
use App\Models\BudgetDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BudgetDocumentController extends Controller
{
    public function index(Budget $budget)
    {
        $documents = $budget->documents()->paginate(10);

        return view('budgets.documents.index', compact('budget', 'documents'));
    }

    public function create(Budget $budget)
    {
        $document = new BudgetDocument();

        return view('budgets.documents.form', compact('budget', 'document'));
    }

    public function store(Budget $budget, BudgetDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'budgets/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $budget->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('budgets.documents.index', $budget->id);
    }

    public function edit(Budget $budget, BudgetDocument $document, $showMode = false)
    {
        return view('budgets.documents.form', compact('budget', 'document', 'showMode'));
    }

    public function update(Budget $budget, BudgetDocument $document, BudgetDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('budgets.documents.index', $budget->id);
    }

    public function destroy(Budget $budget, BudgetDocument $document)
    {
        $document->delete();

        return redirect()->route('budgets.documents.index', $budget->id);
    }

    public function show(Budget $budget, BudgetDocument $document)
    {
        return $this->edit($budget, $document, true);
    }
}
