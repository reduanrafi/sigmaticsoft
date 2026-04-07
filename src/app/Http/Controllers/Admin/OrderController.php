<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $globalObject;
    private $moduleName           = 'orders';
    private $singularVariableName = 'order';
    private $pluralVariableName   = 'orders';

    private $retrievedDataList;
    private $singleData;
    private $filePath = '';

    public function __construct() {

        $this->filePath = $this->adminPath.".".$this->moduleName;

        $this->globalObject = new Order();

    }
    public function index() {

        $this->retrievedDataList = $this->globalObject->all();
        return view($this->filePath . '.index', [$this->pluralVariableName => $this->retrievedDataList]);

    }

    public function create() {

        $this->retrievedDataList = $this->globalObject->all();

        $categories = Category::all();

        return view($this->filePath . '.create', [
            $this->pluralVariableName = $this->retrievedDataList,
            'categories' => $categories,
        ]);
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
        $order = Order::with('items')->find($id);

        //dd($order);
        return view($this->filePath . '.detail', [
            'order'                => $order,
        ]);
    }

    public function Edit($id) {
        $data       = $this->globalObject->findOrFail($id);
        $categories = Category::all();

        return view($this->filePath . '.edit', [

            $this->singularVariableName => $data,

            $this->pluralVariableName   => $this->globalObject->all(),

            'categories'                => $categories,
        ]);
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

            return redirect()->back()->withInput(['error' => $ex->getMessage()]);
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
