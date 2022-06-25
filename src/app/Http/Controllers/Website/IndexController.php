<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    private $globalObject ;

    private $retrievedDataList;
    private $singleData;

    public function __construct()
    {
        $this->globalObject = new User();
    }

    public function Index()
    {


        return view('website.index');
    }


}
