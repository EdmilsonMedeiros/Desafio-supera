@extends('layouts.app')

@section('content')

<div class="container-fluid container-principal">
    <ul class="nav nav-tabs">
    <li class="nav-item active"><a class="nav-link" href="{{ route('home') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Manutenções nos próximos 7 dias"><img src="{{ asset('img/home.png') }}" alt=""> Home</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('car.index') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastro de veículos"><img src="{{ asset('img/registered.png') }}" alt=""> Registrar veículo</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('maintenance.index') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Solicitar, editar e deletar manutenções"><img src="{{ asset('img/settings.png') }}" alt=""> Manutenções</a></li>
    </ul>

    @if (Session::has('sucesso'))
    <p class="text-success error">{{  'Sucesso'    }}</p>
    @endif
    @if (Session::has('no_sucesso'))
    <p class="text-danger error">{{  'Erro'    }}</p>
    @endif

    @if ($errors->has('marca_veiculo'))
        <p class="text-danger error">{{  $errors->has('marca_veiculo') ? $errors->first('marca_veiculo') : ''    }}</p>
    @endif
    @if ($errors->has('modelo_veiculo'))
        <p class="text-danger error">{{  $errors->has('modelo_veiculo') ? $errors->first('modelo_veiculo') : ''    }}</p>
    @endif
    @if ($errors->has('versao_veiculo'))
        <p class="text-danger error">{{  $errors->has('versao_veiculo') ? $errors->first('versao_veiculo') : ''    }}</p>
    @endif


    <div class="col-12 text-primary">
        <div class="title">
            <h4><img src="{{ asset('img/registered.png') }}" alt=""> Cadastre seu veículo aqui</h4>
            <a href="#" type="button" class="btn btn-light" id="plus-icon" title="Solicitar manutenção" data-bs-toggle="modal" data-bs-target="#modal-newcar">Novo veículo</a><br><br>
        </div>
        <br>
        <div class="tabela-manutencoes">

            <table id="table_id" class="table display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Versão</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars_list as $car)
                        <tr>
                            <td>{{ isset($car->id) ? $car->id : ' ' }}                           </td>
                            <td>{{ isset($car->marca_veiculo) ? $car->marca_veiculo : ' ' }}     </td>
                            <td>{{ isset($car->modelo_veiculo) ? $car->modelo_veiculo : ' ' }}   </td>
                            <td>{{ isset($car->versao_veiculo) ? $car->versao_veiculo : ' ' }}   </td>
                            <td>
                                <div class="actions-buttons">
                                    <form action="">
                                        <a id="icon" href="#" title="Editar veículo"><img src="{{ asset('/img/edit.png') }}" alt="" data-bs-toggle="modal" data-bs-target="#modal_car_edit{{ $car->id }}"></a>
                                    </form>
                                    <form onsubmit="return confirm('Tem certexa que deseja excluir?')" action="{{ route('car.destroy', $car->id) }}" method="POST" id="form_{{$car->id}}">
                                        @method('DELETE')
                                        {{ csrf_field() }}
                                        <a href="#orm_{{$car->id}}" id="icon" onclick="confirmSubmit({{$car->id}})" title="Deletar veículo"><img src="{{ asset('/img/trash-bin.png') }}" alt=""></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                            {{-- Modal edita veículo --}}
                            <div class="modal fade" id="modal_car_edit{{ $car->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar veículo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="formulario-registro-veiculo form">
                                            <form action="{{ route('car.update', $car->id) }}" method="post" id="carForm">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="">Qual a marca do veículo?</label>
                                                        <input name="marca_veiculo" id="marca_veiculo" type="text" class="form-control" placeholder="Marca" value="{{ isset($car->marca_veiculo) ? $car->marca_veiculo : '' }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Qual o modelo do veículo?</label>
                                                        <input name="modelo_veiculo" id="modelo_veiculo" type="text" required class="form-control" placeholder="Modelo" value="{{ isset($car->modelo_veiculo) ? $car->modelo_veiculo : '' }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="">Qual a versão do do veículo?</label>
                                                        <input name="versao_veiculo" id="versao_veiculo" type="text" required class="form-control" placeholder="Versão" value="{{ isset($car->versao_veiculo) ? $car->versao_veiculo : '' }}">
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

                                    </div>

                                </div>
                                </div>
                            </div>
                    @endforeach
                </tbody>
            </table>
        </div>
</div>
</div>

{{-- Modal novo veículo --}}
<div class="modal fade" id="modal-newcar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Insira os dados do veículo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="formulario-registro-veiculo form">
                <form action="{{ route('car.store') }}" method="post" id="carForm">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Qual a marca do veículo?</label>
                            <input name="marca_veiculo" id="marca_veiculo" type="text" class="form-control" placeholder="Marca" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Qual o modelo do veículo?</label>
                            <input name="modelo_veiculo" id="modelo_veiculo" type="text" required class="form-control" placeholder="Modelo">
                        </div>
                        <div class="col-md-6">
                            <label for="">Qual a versão do do veículo?</label>
                            <input name="versao_veiculo" id="versao_veiculo" type="text" required class="form-control" placeholder="Versão">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

        </div>

      </div>
    </div>
</div>

<script>
    var id;
    function confirmSubmit(id){
        if(confirm('Tem certeza?')){
            document.getElementById("form_"+id).submit();
        }
    }
    $(document).ready( function () {
        $('#table_id').DataTable({
            order: [[0, 'desc']],
            language: {
                    "lengthMenu": "Mostrar MENU resultados por página",
                    "zeroRecords": "Nenhum resultado encontrado - desculpe",
                    "info": "Mostrando página _PAGE_ de _PAGES_ páginas.",
                    "infoEmpty": "Nenhum resultado encontrado",
                    "infoFiltered": "(Filtro de MAX registros no total)",
                    "search": "Busca rápida: ",
                    "paginate": {
                        "first": "Primeira",
                        "last": "Última",
                        "next": "Próxima",
                        "previous": "Anterior"
                    },
            },
            "pageLength": 10,
        });
    } );

</script>
@endsection
