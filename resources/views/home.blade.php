
@extends('layouts.app')

@section('content')

<div class="container-fluid container-principal">
    <ul class="nav nav-tabs">
        <li class="nav-item active"><a class="nav-link active" href="{{ route('home') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Manutenções nos próximos 7 dias"><img src="{{ asset('img/home.png') }}" alt=""> Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('car.index') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Cadastro de veículos"><img src="{{ asset('img/registered.png') }}" alt=""> Registrar veículo</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('maintenance.index') }}" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" title="Solicitar, editar e deletar manutenções"><img src="{{ asset('img/settings.png') }}" alt=""> Manutenções</a></li>
    </ul>

    <div class="col-12 text-primary">
        <div class="title">
            <h4><img src="{{ asset('img/home.png') }}" alt=""> Manutenções previstas para os próximos 7 dias</h4>
        </div>
        <br>
        <div class="tabela-manutencoes">
            <table id="table_id" class="table display table-hover table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID/Veículo</th>
                        <th>Data solicitação</th>
                        <th>Modelo</th>
                        <th>Versão</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody id="tr_maintenance">

                </tbody>
            </table>
        </div>
</div>

</div>

<!--Modal novo veículo-->
<div class="modal fade" id="modal-newcar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Insira os dados do veículo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="formulario-registro-veiculo form">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Qual a marca do veículo?</label>
                            <input type="text" class="form-control" placeholder="Marca">
                        </div>
                        <div class="col-md-6">
                            <label for="">Qual o modelo do veículo?</label>
                            <input type="text" class="form-control" placeholder="Modelo">
                        </div>
                        <div class="col-md-6">
                            <label for="">Qual a versão do do veículo?</label>
                            <input type="text" class="form-control" placeholder="Versão">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

<script>

    $(document).ready(function(){
        $.ajax({
        url: "http://localhost:8000/api/"+{{ Auth::user()->id }}+"/maintenances",
        type: "GET"
        })
        .done(function( data ) {
                for (var i = 0; i <= data.length; i++){
                    $('#tr_maintenance').append(
                        "<tr>" +
                            "<td>" + data[i].id         + "</td>"  +
                            "<td>" + data[i].car_id  + " - " + data[i].marca_veiculo  + "</td>" +
                            "<td>" + data[i].created_at     + "</td>" +
                            "<td>" + data[i].modelo_veiculo + "</td>" +
                            "<td>" + data[i].versao_veiculo + "</td>" +
                            "<td>" + data[i].descricao      + "</td>" +
                        "</tr>",
                    )
                }
        });
    });
</script>
@endsection
