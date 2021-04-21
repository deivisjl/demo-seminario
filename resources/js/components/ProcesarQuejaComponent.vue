<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <table class="table table-bordered">
            <tr><th colspan="2">Datos del proveedor</th></tr>
            <tr>
                <td>NIT</td>
                <td v-if="registro.nit">{{ registro.nit }}</td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td v-if="registro.negocio">{{ registro.negocio }}</td>
            </tr>
            <tr>
                <td>Actividad económica</td>
                <td v-if="registro.actividad_economica">{{ registro.actividad_economica }}</td>
            </tr>
            <tr>
                <td>Municipio</td>
                <td v-if="registro.municipio">{{ registro.municipio }}</td>
            </tr>
            <tr>
                <td>Departamento</td>
                <td v-if="registro.departamento">{{ registro.departamento }}</td>
            </tr>
            <tr><th>Datos del consumidor</th></td></tr>
            <tr>
                <td>Nacionalidad</td>
                <td v-if="registro.nacionalidad">{{ registro.nacionalidad == 1 ? 'Guatemalteco' : 'Extranjero'  }}</td>
            </tr>
            <tr>
                <td>Teléfono de contacto</td>
                <td v-if="registro.telefono_contacto">{{ registro.telefono_contacto }}</td>
            </tr>
            <tr>
                <td>Correo de contacto</td>
                <td v-if="registro.correo_contacto">{{ registro.correo_contacto }}</td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td v-if="registro.nombres">{{ registro.nombres }} {{ registro.apellidos }}</td>
            </tr>
            <tr><th colspan="2">Detalle</th></tr>
            <tr>
                <td v-if="registro.detalle" colspan="2">{{ registro.detalle }}</td>
            </tr>
            <tr><th colspan="2">Solicitud</th></tr>
            <tr>
                <td v-if="registro.solicitud" colspan="2">{{ registro.solicitud }}</td>
            </tr>
        </table>
        <div class="row" v-if="registro.status='Pendiente'">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" @click="procesar()"><i class="fas fa-check-double"></i> Procesar</button>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
    export default{
        data(){
            return {
                loading:false,
                datos:''
            }
        },
        props:{
            registro:{}
        },
        created(){

        },
        methods:{
            formato_fecha(fecha)
            {
                if(fecha)
                {
                    return moment(fecha).format("DD-MM-YYYY")
                }
                else
                {
                    return ''
                }
            },
            procesar(){
                let data = {
                    'no':this.registro.no
                }
                this.loading = true
                axios.post(abs_path + '/procesar-queja', data)
                    .then(r => {
                        Toastr.success(r.data.data,'Mensaje')
                        this.loading = false
                        setTimeout(function(){
                            window.location.href = abs_path + '/quejas'
                        },200)
                    })
                    .catch(error => {
                        this.loading = false
                        Toastr.error(error.response.data.error,'Mensaje')
                    })
            },
        },
    }
</script>
