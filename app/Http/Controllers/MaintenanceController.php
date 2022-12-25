<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maintenance_list = Maintenance::whereuser_id(Auth::id())->get();
        $cars_list = Car::whereuser_id(Auth::id())->get();
        return view('maintenance', compact('cars_list', 'maintenance_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'car_id'    => 'required',
            'descricao' => 'required'
        ];

        $feed_backs = [
            'required'  => 'Campo obrigatório: :attribute',
        ];

        $request->validate($rules, $feed_backs);

        $maintenance_create = Maintenance::create([
            'car_id'    => $request->car_id,
            'user_id'   => Auth::id(),
            'descricao' => $request->descricao
        ]);

        if($maintenance_create){
            return redirect()->back()->with('sucesso', 'sucesso');
        }else{
            return redirect()->back()->with('no_sucesso', 'no_sucesso');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $rules = [
            'descricao'  => 'required|max:255',
        ];

        $feed_backs = [
            'required'  => 'Campo obrigatório: :attribute',
            'descricao.max' => 'O campo: :attribute aceita no máximo 255 caracteres'
        ];

        $request->validate($rules, $feed_backs);

        if($maintenance->update($request->all())){
            return redirect()->back()->with('sucesso', 'sucesso');
        }else{
            return redirect()->back()->with('no_sucesso', 'no_sucesso');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Maintenance  $maintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Maintenance $maintenance)
    {
        if($maintenance->delete()){
            return redirect()->back()->with('sucesso', 'sucesso');
        }else{
            return redirect()->back()->with('no_sucesso', 'no_sucesso');
        }
    }
}
