<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte general de quejas</title>
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
        <tr style="text-align: center">
            <td>Reporte de quejas del <strong>{{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }}</strong> hasta <strong>{{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</strong></td>
        </tr>
    </table>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: 8%;">#</th>
                <th>Código</th>
                <th>Entidad</th>
                <th>Nit</th>
                <th>Actividad económica</th>
                <th>Municipio</th>
                <th>Departamento</th>
                <th>Contacto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @if(sizeof($registros) > 0)
                @foreach ($registros as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->codigo }}</td>
                        <td>{{ $item->negocio }}</td>
                        <td>{{ $item->nit }}</td>
                        <td>{{ $item->actividad }}</td>
                        <td>{{ $item->municipio }}</td>
                        <td>{{ $item->departamento }}</td>
                        <td>{{ $item->telefono_contacto }}</td>
                        <td style="text-align:center">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            @else
                    <tr style="text-align:center">
                        <td colspan="8">No se encontraron registros</td>
                    </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
