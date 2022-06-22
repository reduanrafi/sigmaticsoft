<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductsController extends Controller {
    private $globalObject;
    private $moduleName           = 'products';
    private $singularVariableName = 'product';
    private $pluralVariableName   = 'products';

    private $retrievedDataList;
    private $singleData;
    private $filePath = 'admin.pages.products';

    public function __construct() {

        $this->globalObject = new Product();
    }
    public function index() {

        $this->retrievedDataList = $this->globalObject->all();
        return view($this->filePath . '.index', [$this->pluralVariableName => $this->retrievedDataList]);
    }

    public function create() {

        $this->retrievedDataList = $this->globalObject->all();

        $category                = Category::all();

        return view($this->filePath . '.create', [$this->pluralVariableName = $this->retrievedDataList], compact('category'));
    }

    public function store(Request $request) {
        $result = false;

        try {

            $result = $this->globalObject->create($this->globalObject->GetData($request->all()));

            if ($result) {
                return redirect()->back()->with(['success' => $this->moduleName . ' created successfully']);
            }

            return redirect()->back()->with(['error' => 'Unable to handle this request !']);

        } catch (QueryException $ex) {

            return redirect()->back()->with(['error' => $ex->getMessage()]);
        }
    }

    public function show($id) {
        //
    }

    public function Edit($id) {
        $data     = $this->globalObject->findOrFail($id);
        $category = Category::all();

        return view($this->filePath . '.edit', [

            $this->singularVariableName => $data,

            $this->pluralVariableName   => $this->globalObject->all(),
        ], compact('category'));
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}
