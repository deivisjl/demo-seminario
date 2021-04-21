<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form @submit.prevent="validar()" autocomplete="off">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="inputPassword2" class="sr-only">No. de queja</label>
                        <input type="text" class="form-control" name="no" placeholder="No. de queja" v-model="no" v-validate="'required|numeric'">
                        <error-form :attribute_name="'no'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Consultar</button>
                    </div>
                </div>
            </div>
            <div class="row" v-if="datos">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr><th colspan="2" class="text-center">Estado: {{ datos.status }}</th></tr>
                        <tr><th colspan="2">Datos del proveedor</th></tr>
                        <tr>
                            <td>NIT</td>
                            <td v-if="datos.nit">{{ datos.nit }}</td>
                        </tr>
                        <tr>
                            <td>Empresa</td>
                            <td v-if="datos.negocio">{{ datos.negocio }}</td>
                        </tr>
                        <tr>
                            <td>Actividad económica</td>
                            <td v-if="datos.actividad">{{ datos.actividad }}</td>
                        </tr>
                        <tr>
                            <td>Dirección</td>
                            <td v-if="datos.direccion">{{ datos.direccion }}</td>
                        </tr>
                        <tr>
                            <td>Municipio</td>
                            <td v-if="datos.municipio">{{ datos.municipio }}</td>
                        </tr>
                        <tr>
                            <td>Departamento</td>
                            <td v-if="datos.departamento">{{ datos.departamento }}</td>
                        </tr>
                        <tr>
                            <td>Número de documento</td>
                            <td v-if="datos.no_documento">{{ datos.no_documento }}</td>
                        </tr>
                        <tr>
                            <td>Fecha del documento</td>
                            <td v-if="datos.fecha_documento">{{ formato_fecha(datos.fecha_documento) }}</td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr>
                            <th colspan="2">Detalle</th>
                        </tr>
                        <tr>
                            <td v-if="datos.detalle">{{ datos.detalle }}</td>
                        </tr>
                        <tr>
                            <th>Solicitud</th>
                        </tr>
                        <tr>
                            <td v-if="datos.solicitud">{{ datos.solicitud }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import moment from 'moment';
    export default{
        data(){
            return {
                loading:false,
                no:'',
                datos:''
            }
        },
        mounted(){
            this.config_error()
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
             validar(){
                this.$validator.validateAll().then((result) =>{
                    if(result){
                        this.consultar()
                    }
                });
            },
            consultar(){
                let data = {
                    'no':this.no,
                }
                this.loading = true
                axios.post(abs_path + '/consultar-queja', data)
                    .then(r => {
                        if(!r.data.data)
                        {
                            this.datos = ''
                            Toastr.info('No se encontraron registros asociados','Mensaje')
                        }
                        else
                        {
                            this.datos = r.data.data
                        }
                        this.loading = false
                    })
                    .catch(error => {
                        this.loading = false
                        Toastr.error(error.response.data.error,'Mensaje')
                    })
            },

            config_error(){
            let self = this
               let dict = {
                custom:{
                    no:{
                        required:'El número de queja es requerido',
                        numeric:'Debe escribir un número válido'
                    },
                }
               }
              self.$validator.localize('es',dict);
          },
        },
    }
</script>

