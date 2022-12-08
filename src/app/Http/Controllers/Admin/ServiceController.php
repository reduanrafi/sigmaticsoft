<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\services;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ServiceController extends Controller {
    private $globalObject;
    private $moduleName           = "Service";
    private $singularVariableName = 'service';
    private $pluralVariableName   = 'services';

    private $retrievedDataList;
    private $singleData;
    private $filePath = "admin.pages.service";

    public function __construct() {

        $this->globalObject = new services();
    }

    public function Index() {

        $this->retrievedDataList = $this->globalObject->all();

        return view($this->filePath . '.index', [

            $this->pluralVariableName => $this->retrievedDataList,

        ]);
    }

    public function Create() {

        $this->retrievedDataList = $this->globalObject->all();

        return view($this->filePath . '.create', [

            $this->pluralVariableName => $this->retrievedDataList,
        ]);
    }

    public function Edit($id) {
        $data = $this->globalObject->findOrFail($id);

        return view($this->filePath . '.edit', [

            $this->singularVariableName => $data,

            $this->pluralVariableName   => $this->globalObject->all(),
        ]);
    }

    public function Store(Request $request) {

        $result = false;

        try
        {
            $result = $this->globalObject->create($this->globalObject->GetData($request->all()));

            if ($result) {
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

    public function destroy($id) {

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
