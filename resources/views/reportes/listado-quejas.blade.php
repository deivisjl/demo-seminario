@extends('layouts.app')

@section('content')
<div id="loading"></div>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-md">
                <div class="card-header">
                    <h3 class="card-title-custom">
                        Historial de quejas
                    </h3>
                </div>

                <div class="card-body">
                    <table id="listar" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                             <th style="width:15%; text-align: center">#</th>
                             <th>No.</th>
                             <th>NIT</th>
                             <th>Empresa</th>
                             <th>Actividad económica</th>
                             <th>Fecha de registro</th>
                             <th>Estado</th>
                             <th>Acción</th>
                           </tr>
                         </thead>
                     </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(e){
        listar();
    });

    var  listar = function(){
        var table = $("#listar").DataTable({
            "processing": true,
            "serverSide": true,
            "destroy":true,
            "responsive": true,
            "autoWidth": false,
            "ajax":{
            'url': '/listar-quejas',
            'type': 'GET'
          },
          "columns":[
              {'data': 'id',"visible":false},
              {'data': 'no'},
              {'data': 'nit'},
              {'data': 'negocio'},
              {'data': 'actividad'},
              {'data': 'fecha',"orderable":false,"searchable":false},
              {'data': 'status',"render":function(data, type, row, meta){
                 if(row.status == 'Pendiente'){
                    return '<span class="badge badge-warning">'+ data +'</span>'
                 }else if(row.status == 'Procesado'){
                    return '<span class="badge badge-success">'+ data +'</span>'
                 }
              }},
              {'defaultContent':'<a href="" class="editar btn btn-info btn-sm"  data-toggle="tooltip" data-placement="top" title="Detalle registro"><i class="fa fa-edit"></i> Detalle</a>', "orderable":false}
          ],
          "language": language_spanish,
          "order": [[ 0, "desc" ]]
        });
        obtener_data_editar("#listar tbody",table);
    }

    var obtener_data_editar = function(tbody,table){
         $(tbody).on("click","a.editar",function(e){
             e.preventDefault();
            var data = table.fnGetData($(this).parents("tr"));

            var id = data.no;
             window.location.href = "/detalle-historial/" + id + "/queja";
          });
      }
</script>
@endsection
