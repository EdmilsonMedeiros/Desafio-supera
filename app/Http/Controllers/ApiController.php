<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{


    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $maintenances = Maintenance::whereuser_id($user_id)
        ->whereBetween('created_at', [date('Y-m-d H:i:s', strtotime('-1 day')), date('Y-m-d H:i:s', strtotime('+7 days'))])
        ->orderBy('id', 'DESC')
        ->get();

        foreach($maintenances as $key => $maintenance){
            $arrayMaintenance[$key] = [
                'id' => $maintenance->id,
                'car_id' => $maintenance->car_id,
                'marca_veiculo' => isset($maintenance->car->marca_veiculo) ? $maintenance->car->marca_veiculo : '',
                'modelo_veiculo' => isset($maintenance->car->modelo_veiculo) ? $maintenance->car->modelo_veiculo : '',
                'versao_veiculo' => isset($maintenance->car->versao_veiculo) ? $maintenance->car->versao_veiculo : '',
                'descricao' => $maintenance->descricao,
                'created_at' => date('d/m/Y H:i:s', strtotime($maintenance->created_at))
            ];

        }
        return response()->json($arrayMaintenance);
    }

    /**
     *
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  Maintenance $maintenance
     * @return \Illuminate\Http\Response
     */
    public function ajaxDestroy(Maintenance $maintenance)
    {
        $maintenance->delete();
    }
}
