@extends('layouts.app')

@section('content')

<div class="container-fluid container-principal">
    <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link" href="{{ route('home') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Manutenções nos próximos 7 dias"><img src="{{ asset('img/home.png') }}" alt=""> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('car.index') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastro de novos veículos"><img src="{{ asset('img/registered.png') }}" alt=""> Registrar veículo</a></li>
        <li class="nav-item"><a class="nav-link active" href="{{ route('maintenance.index') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Solicitar, editar e deletar manutenções"><img src="{{ asset('img/settings.png') }}" alt=""> Manutenções</a></li>
    </ul>

    @if (Session::has('sucesso'))
    <p class="text-success error">{{  'Sucesso'    }}</p>
    @endif
    @if (Session::has('no_sucesso'))
    <p class="text-danger error">{{  'Erro'    }}</p>
    @endif

    @if ($errors->has('user_id'))
    <p class="text-danger error">{{  $errors->has('user_id') ? $errors->first('user_id') : ''    }}</p>
    @endif
    @if ($errors->has('descricao'))
    <p class="text-danger error">{{  $errors->has('descricao') ? $errors->first('descricao') : ''    }}</p>
    @endif

    <div class="col-12 text-primary">
        <div class="title">
            <h4><img src="{{ asset('img/settings.png') }}" alt=""> Manutenções</h4>
            <a href="#" type="button" class="btn btn-light" id="plus-icon" title="Solicitar manutenção" data-bs-toggle="modal" data-bs-target="#modal-maintenance">Nova manutenção</a><br><br>
        </div>
        <br>
        <div class="tabela-manutencoes">

            <table id="table_id" class="table display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th width="100">ID / Veículo</th>
                        <th>Data solicitação</th>
                        <th>Modelo</th>
                        <th>Versão</th>
                        <th>Descrição</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenance_list as $maintenance)
                        <tr>
                            <td>{{ isset($maintenance->id) ? $maintenance->id : '' }}</td>
                            <td>{{ (isset($maintenance->car_id) && isset($maintenance->car->marca_veiculo) ? $maintenance->car_id . " - " . $maintenance->car->marca_veiculo : '') ?? $maintenance->car_id}}</td>
                            <td>{{ isset($maintenance->created_at) ? date('d/m/Y H:i:s', strtotime($maintenance->created_at)) : '' }}</td>
                            <td>{{ (isset($maintenance->car_id) && isset($maintenance->car->modelo_veiculo) ? $maintenance->car->modelo_veiculo : '') ?? $maintenance->car_id}}</td>
                            <td>{{ (isset($maintenance->car_id) && isset($maintenance->car->versao_veiculo) ? $maintenance->car->versao_veiculo : '') ?? $maintenance->car_id}}</td>
                            <td>{{ isset($maintenance->descricao) ? $maintenance->descricao : '' }}</td>
                            <td>
                                <div class="actions-buttons">
                                    <form action="">
                                        <a id="icon" href="#" title="Editar"><img src="{{ asset('/img/edit.png') }}" alt="" data-bs-toggle="modal" data-bs-target="#modal_car_edit{{ $maintenance->id }}"></a>
                                    </form>
                                    <form onsubmit="return confirm('Tem certexa que deseja excluir?')" action="{{ route('maintenance.destroy', $maintenance->id) }}" method="POST" id="form_{{$maintenance->id}}">
                                        @method('DELETE')
                                        {{ csrf_field() }}
                                        <a href="#form_{{$maintenance->id}}" id="icon" onclick="confirmSubmit({{$maintenance->id}})" title="Deletar"><img src="{{ asset('/img/trash-bin.png') }}" alt=""></a>
                                    </form>
                                </div>
                            </td>
                        </tr>
                            {{-- Modal edita manutenção --}}
                            <div class="modal fade" id="modal_car_edit{{ $maintenance->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="formulario-registro-veiculo form">
                                            <form action="{{ route('maintenance.update', $maintenance->id) }}" method="post" id="maintenanceForm">
                                                {{ csrf_field() }}
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="">Veículo</label>
                                                        <input type="text" class="form-control" value="{{ (isset($maintenance->car_id) && isset($maintenance->getCar->marca_veiculo) ? $maintenance->car_id . " - " . $maintenance->getCar->marca_veiculo : '') ? $maintenance->car_id : '' }}" readonly>
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="">Descrição <span class="text-gray">(255 caracteres)</span></label>
                                                        <textarea class="form-control" name="descricao" id="" cols="30" rows="5" placeholder="Descreva a situação do veículo" required maxlength="255">{{ $maintenance->descricao }}</textarea>
                                                    </div>

                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
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

<!--Modal nova manutenção-->
<div class="modal fade" id="modal-maintenance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Solicitar manutenção</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="formulario-manutencao form">
                <form action="{{ route('maintenance.store') }}" method="POST" id="#form_naibtenance">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <label for="">Selecione o veículo</label>
                            <select class="form-control" name="car_id" id="" required>
                                <option value="" selected disabled>Nenhum</option>
                                @foreach ($cars_list as $car)
                                    <option value="{{ $car->id }}">{{ $car->id . " - ". $car->marca_veiculo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="">Descrição <span class="text-gray">(255 caracteres)</span></label>
                            <textarea class="form-control" name="descricao" id="" cols="30" rows="5" placeholder="Descreva a situação do veículo" required maxlength="255"></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Solicitar</button>
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
