<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CaseStudyController extends Controller {
    private $globalObject;
    private $moduleName           = "Case Study";
    private $singularVariableName = 'caseStudy';
    private $pluralVariableName   = 'caseStudies';

    public function __construct() {
        $this->globalObject = new CaseStudy();
    }

    public function index() {
        $dataList = $this->globalObject->all();
        return view('admin.pages.case_studies.index', [
            'caseStudies' => $dataList,
        ]);
    }

    public function create() {
        return view('admin.pages.case_studies.create');
    }

    public function edit($id) {
        $data = $this->globalObject->findOrFail($id);
        return view('admin.pages.case_studies.edit', [
            'caseStudy' => $data,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:case_studies,slug',
            'subtitle' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'client_context' => 'nullable|string',
            'existing_environment' => 'nullable|string',
            'business_problem' => 'nullable|string',
            'solution' => 'nullable|string',
            'node1_title' => 'nullable|string|max:255',
            'node1_desc' => 'nullable|string|max:255',
            'node2_title' => 'nullable|string|max:255',
            'node2_desc' => 'nullable|string|max:255',
            'node3_title' => 'nullable|string|max:255',
            'node3_desc' => 'nullable|string|max:255',
            'implementation' => 'nullable|string',
            'outcome' => 'nullable|string',
            'lessons_learned' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'stack' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'capability_1' => 'nullable|string|max:255',
            'capability_2' => 'nullable|string|max:255',
            'capability_3' => 'nullable|string|max:255',
            'capability_4' => 'nullable|string|max:255',
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|integer',
            'is_featured' => 'nullable|integer',
        ]);

        try {
            $data = $request->all();
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            if ($this->globalObject->create($this->globalObject->GetData($data))) {
                return redirect()->route('case-study.index')->with(['success' => $this->moduleName . " created successfully"]);
            }
            return redirect()->back()->with(['error' => "Unable to handle this request !"]);
        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function update(Request $request, $id) {
        $oldData = $this->globalObject->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:case_studies,slug,' . $id,
            'subtitle' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'client_context' => 'nullable|string',
            'existing_environment' => 'nullable|string',
            'business_problem' => 'nullable|string',
            'solution' => 'nullable|string',
            'node1_title' => 'nullable|string|max:255',
            'node1_desc' => 'nullable|string|max:255',
            'node2_title' => 'nullable|string|max:255',
            'node2_desc' => 'nullable|string|max:255',
            'node3_title' => 'nullable|string|max:255',
            'node3_desc' => 'nullable|string|max:255',
            'implementation' => 'nullable|string',
            'outcome' => 'nullable|string',
            'lessons_learned' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'timeline' => 'nullable|string|max:255',
            'stack' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'capability_1' => 'nullable|string|max:255',
            'capability_2' => 'nullable|string|max:255',
            'capability_3' => 'nullable|string|max:255',
            'capability_4' => 'nullable|string|max:255',
            'cta_title' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:255',
            'cta_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|integer',
            'is_featured' => 'nullable|integer',
        ]);

        try {
            $data = $request->all();
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['title']);
            }
            if ($oldData->update($this->globalObject->GetData($data))) {
                return redirect()->route('case-study.index')->with(['success' => $this->moduleName . " updated successfully"]);
            }
            return redirect()->back()->with(['error' => "Unable to update"]);
        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function destroy($id) {
        try {
            if ($this->globalObject->destroy($id)) {
                return redirect()->route('case-study.index')->with(['success' => $this->moduleName . " deleted successfully"]);
            }
        } catch (QueryException $exception) {
            return redirect()->back()->with(['error' => $exception->getMessage()]);
        }
        return redirect()->back()->with(['error' => "Unable to handle this request !"]);
    }
}
