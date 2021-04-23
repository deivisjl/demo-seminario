<template>
    <div>
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-outline-danger" @click="imprimir()"><i class="far fa-file-pdf fa-2x icon-dw-rojo"></i></button>
            </div>
        </div>
        <div id="detalle" ref="detalle">
                <table class="table">
                    <tr>
                        <td width="15%">
                            <img src="../../../img/diaco-logo.png" style="height:60px; width:auto">
                        </td>
                        <td width="85%" class="text-center">
                                <h4>Dirección de Atención y Asistencia al Consumidor DIACO</h4>
                        </td>
                    </tr>
                </table>
                <table class="table table-borderless table-custom">
                    <thead>
                        <tr>
                            <th colspan="3" class="text-center">Boleta de registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="2" class="text-center">Datos del consumidor</th>
                        </tr>
                        <tr>
                            <td width="33%">Número de queja</td>
                            <td colspan="2">{{ registro.no }}</td>
                        </tr>
                        <tr>
                            <td width="33%">Teléfono de contacto</td>
                            <td colspan="2">{{ registro.telefono_contacto }}</td>
                        </tr>
                        <tr>
                            <td width="33%">Correo de contacto</td>
                            <td colspan="2">{{ registro.correo_contacto }}</td>
                        </tr>
                        <tr>
                            <td width="33%">Nombre</td>
                            <td colspan="2">{{ registro.nombres }} {{ registro.apellidos }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">Datos del proveedor</th>
                        </tr>
                        <tr>
                            <td width="33%">Nombre del negocio o institución</td>
                            <td colspan="2">{{ registro.negocio }}</td>
                        </tr>
                        <tr>
                            <td width="33%">NIT</td>
                            <td colspan="2">{{ registro.nit }}</td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center">Detalle de la queja</th>
                        </tr>
                        <tr>
                            <td width="33%">Detalle</td>
                            <td colspan="2">{{ registro.detalle }}</td>
                        </tr>
                        <tr>
                            <td width="33%">Solicitud</td>
                            <td colspan="2">{{ registro.solicitud }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">{{ registro.updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
    </div>
</template>
<script>
import html2canvas from 'html2canvas'
var pdfMake = require('pdfmake/build/pdfmake.js')
var pdfFonts = require('pdfmake/build/vfs_fonts.js')

export default{
    data(){
        return{

        }
    },
    components:{

    },
    props:{
        registro:{}
    },
    mounted(){

    },
    methods:{
        imprimir()
        {
            html2canvas(this.$refs.detalle,{scale:3}).then(canvas => {
                    var data = canvas.toDataURL("image/png");
                        var docDefinition = {
                            content: [{
                                image: data,
                                width: 500,
                            }],
                            pageSize: 'LETTER',
                        };
                    pdfMake.createPdf(docDefinition).download('boleta');
                    }).catch((error) => {
                        console.log(error)
                });
        }
    }
}

</script>
