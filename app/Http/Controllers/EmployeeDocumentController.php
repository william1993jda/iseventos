<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeDocumentRequest;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeDocumentController extends Controller
{
    public function index(Employee $employee)
    {
        $documents = $employee->documents()->orderBy('name', 'ASC')->paginate(10);

        return view('employees.documents.index', compact('employee', 'documents'));
    }

    public function create(Employee $employee)
    {
        $document = new EmployeeDocument();

        return view('employees.documents.form', compact('employee', 'document'));
    }

    public function store(Employee $employee, EmployeeDocumentRequest $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            $url = 'employees/documents/' . $filename;

            Storage::disk("s3")->put($url, file_get_contents($file));

            $employee->documents()->create([
                'name' => $request->get('name'),
                'url' => $url,
            ]);
        }

        return redirect()->route('employees.documents.index', $employee->id);
    }

    public function edit(Employee $employee, EmployeeDocument $document, $showMode = false)
    {
        return view('employees.documents.form', compact('employee', 'document', 'showMode'));
    }

    public function update(Employee $employee, EmployeeDocument $document, EmployeeDocumentRequest $request)
    {
        $document->update($request->all());

        return redirect()->route('employees.documents.index', $employee->id);
    }

    public function destroy(Employee $employee, EmployeeDocument $document)
    {
        $document->delete();

        return redirect()->route('employees.documents.index', $employee->id);
    }

    public function show(Employee $employee, EmployeeDocument $document)
    {
        return $this->edit($employee, $document, true);
    }
}
