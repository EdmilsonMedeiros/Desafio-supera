<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars_list = Car::whereuser_id(Auth::id())->get();

        return view('car_register', compact('cars_list'));
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
            'marca_veiculo'  => 'required',
            'modelo_veiculo' => 'required',
            'versao_veiculo' => 'required',
        ];

        $feed_backs = [
            'marca_veiculo.required'  => 'Campo obrigatório: :attribute',
            'modelo_veiculo.required' => 'Campo obrigatório: :attribute',
            'versao_veiculo' => 'Campo obrigatório: :attribute',
        ];

        $request->validate($rules, $feed_backs);

        $car_create = Car::create([
            'marca_veiculo'  => $request->marca_veiculo,
            'modelo_veiculo' => $request->modelo_veiculo,
            'versao_veiculo' => $request->versao_veiculo,
            'user_id'        => Auth::id()
        ]);

        if($car_create){
            return redirect()->back()->with('sucesso', 'sucesso');
        }else{
            return redirect()->back()->with('no_sucesso', 'no_sucesso');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $rules = [
            'marca_veiculo'  => 'required',
            'modelo_veiculo' => 'required',
            'versao_veiculo' => 'required',
        ];

        $feed_backs = [
            'required'  => 'Campo obrigatório: :attribute',
        ];

        $request->validate($rules, $feed_backs);

        if($car->update($request->all())){
            return redirect()->back()->with('sucesso', 'sucesso');
        }else{
            return redirect()->back()->with('no_sucesso', 'no_sucesso');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        if($car->delete()){
            return redirect()->back()->with('sucesso', 'sucesso');
        }else{
            return redirect()->back()->with('no_sucesso', 'no_sucesso');
        }
    }
}
