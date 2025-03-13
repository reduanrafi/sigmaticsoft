<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Insight;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class InsightController extends Controller {
    private $globalObject;
    private $moduleName           = "Insight";
    private $singularVariableName = 'insight';
    private $pluralVariableName   = 'insights';

    private $retrievedDataList;
    private $singleData;

    public function __construct() {
        $this->globalObject = new Insight();
    }

    public function Index() {

        $this->retrievedDataList = $this->globalObject->all();

        return view('admin.pages.' . $this->pluralVariableName . '.index', [
            $this->pluralVariableName => $this->retrievedDataList,
        ]);
    }

    public function Create() {

        $this->retrievedDataList = $this->globalObject->all();

        return view('admin.pages.' . $this->pluralVariableName . '.create', [
            $this->pluralVariableName => $this->retrievedDataList,
        ]);
    }

    public function Edit($id) {
        $data = $this->globalObject->findOrFail($id);

        return view('admin.pages.' .$this->pluralVariableName . '.edit', [
            $this->singularVariableName => $data,
            $this->pluralVariableName   => $this->globalObject->all(),
        ]);
    }

    public function Store(Request $request) {

        try
        {
            if ($this->globalObject->create($this->globalObject->GetData($request->all()))) {
                return redirect()->back()->with(['success' => $this->moduleName . " created successfully"]);
            }
            return redirect()->back()->with(['error' => "Unable to handle this request !"]);
        } catch (QueryException $ex) {
            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }

    }

    public function Update(Request $request, $id) {

        $result = false;

        $oldData = $this->globalObject->findOrFail($id);

        try {

            $result = $oldData->update($this->globalObject->GetData($request->all()));

            if ($result) {

                return redirect()->back()->with(['success' => $this->moduleName . "  updated successfully"]);
            }

            return redirect()->back()->with(['error' => "Unable to update"]);

        } catch (QueryException $ex) {

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }

    }

    public function Delete($id) {

        try {
            if ($this->globalObject->destroy($id)) {
                return redirect()->back()->with(['success' => $this->moduleName . "  deleted successfully"]);
            }
        } catch (QueryException $exception) {
            return redirect()->back()->with(['error' => $exception->getMessage()]);

        }
        return redirect()->back()->with(['error' => "Unable to handle this request !"]);

    }
}
