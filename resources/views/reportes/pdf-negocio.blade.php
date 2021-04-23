<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de quejas por negocio</title>
    <style>
        .table-custom{
            width: 100%;
        }
        .table{
            width: 100%;
        }
        .text-center{
            text-align: center;
        }
        .table-bordered {
            border: 1px solid #000;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 8px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #000;
        }
        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
            border: 1px solid #000;
        }
        .table {
            border-spacing: 0;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table class="table-custom">
        <tr>
            <td>
                <img src="{{ asset('img/diaco-logo.png') }}" alt="logo" style="height: 65px;">
            </td>
        </tr>
        <tr style="text-align: center">
            <td>Reporte de quejas por negocio, del <strong>{{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }}</strong> hasta <strong>{{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</strong></td>
        </tr>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 8%;">#</th>
                <th>Nombre</th>
                <th>NIT</th>
                <th>Número de quejas</th>
                <th>Dirección</th>
                <th>Municipio</th>
                <th>Departamento</th>
            </tr>
        </thead>
        <tbody>
            @if(sizeof($registros) > 0)
                @foreach ($registros as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->negocio }}</td>
                        <td>{{ $item->nit }}</td>
                        <td class="text-center">{{ $item->cantidad }}</td>
                        <td>{{ $item->direccion }}</td>
                        <td>{{ $item->municipio}}</td>
                        <td>{{ $item->departamento }}</td>
                    </tr>
                @endforeach
            @else
                    <tr style="text-align:center">
                        <td colspan="7">No se encontraron registros</td>
                    </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
