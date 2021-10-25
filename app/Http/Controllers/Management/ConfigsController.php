<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Management\Configuration as Config;
use App\LibaryClass as Libary;

class ConfigsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lab = Libary::generateMatricNumber(13, 1);
        return $lab;
    }

    public function adminDashboard(Request $req){
        $session = $req->input('s');
        return Libary::adminDashboard($session);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $config =  Config::where('name', $request->name)->first();
        if($config && $config->name == "matric"){
            $config->param1 = $request->param1;
            $config->param2 = $request->param2;
            $config->param3 = $request->param3;
            $config->param4 = $request->param4;
            $config->save();
            return $config;
        }
        return $config;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        if($id == "matric"){
            if($id == "matric"){
                $matric = Config::where('name', $id)->first();
                if(!$matric){
                    $config = new Config();
                    $config->name = "matric";
                    $config->param1 = 3;
                    $config->param2 = 5;
                    $config->param3 = 7;
                    $config->param4 = 1;
                    $config->save();
                    return $config;
                }
                return $matric;
            }
        }

        return null;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
