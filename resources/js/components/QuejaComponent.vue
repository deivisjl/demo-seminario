<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form id="msform" autocomplete="off">
            <!-- progressbar -->
            <ul id="progressbar">
                <li class="active" id="account">
                    <strong>Datos del consumidor</strong>
                </li>
                <li id="personal"><strong>Datos del proveedor</strong></li>
                <li id="payment"><strong>Datos de la queja</strong></li>
                <li id="confirm"><strong>Verificar</strong></li>
            </ul>
            <!-- fieldsets -->
            <fieldset>
                <div class="form-card">
                    <div class="form-group">
                        <label for="">Nacionalidad</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio-nacionalidad" id="radio1" v-model="origen" value="1"/>
                            <label class="form-check-label" for="radio1">Guatemalteco</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="radio-nacionalidad" id="radio2" v-model="origen" value="2"/>
                            <label class="form-check-label" for="radio2">Extranjero</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Teléfono de contacto</label>
                        <input type="text" class="form-control" name="telefono" v-model="telefono" v-validate="'required|numeric|regex:^([0-9]{8})$'"/>
                        <error-form :attribute_name="'telefono'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="">Correo de contacto <small>(opcional)</small></label>
                        <input type="email" class="form-control" name="correo" v-model="correo" v-validate="'email'"/>
                        <error-form :attribute_name="'correo'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nombres</label>
                        <input type="text" class="form-control" name="nombres" v-model="nombres" v-validate="'required'"/>
                        <error-form :attribute_name="'nombres'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" v-model="apellidos" v-validate="'required'"/>
                        <error-form :attribute_name="'apellidos'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <input type="button" name="next" class="next action-button btn btn-success" value="Siguiente"/>
            </fieldset>
            <fieldset>
                <div class="form-card">
                    <div class="form-group">
                        <label for="" class="control-label">NIT</label>
                        <input type="text" class="form-control" name="nit" v-model="nit" v-validate="'required'"/>
                        <error-form :attribute_name="'nit'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Nombre de la empresa</label>
                        <input type="text" class="form-control" name="negocio" v-model="negocio" v-validate="'required'"/>
                        <error-form :attribute_name="'negocio'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="">Actividad económica</label>
                        <select name="actividad" class="form-control" v-model="actividad" v-validate="'required'">
                            <template v-for="item in actividades">
                                <option v-bind:value="{id: item.id, text: item.nombre}">{{ item.nombre }}</option>
                            </template>
                        </select>
                        <error-form :attribute_name="'actividad'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Dirección</label>
                        <textarea class="form-control" name="direccion" v-model="direccion" v-validate="'required'"></textarea>
                        <error-form :attribute_name="'direccion'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Departamento</label>
                        <select name="departamento" v-model="departamento" @change="llenar_municipios"  v-validate="'required'" class="form-control">
                            <template v-for="item in departamentos">
                                <option v-bind:value="{id: item.id, text: item.nombre}">{{ item.nombre }}</option>
                            </template>
                        </select>
                        <error-form :attribute_name="'departamento'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Municipio</label>
                        <select name="municipio" v-validate="'required'" v-model="municipio" class="form-control">
                            <template v-for="muni in municipios">
                                <option v-bind:value="{id: muni.id, text: muni.nombre}">{{ muni.nombre }}</option>
                            </template>
                        </select>
                        <error-form :attribute_name="'municipio'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <input type="button" name="previous" class="previous action-button-previous btn btn-danger" value="Anterior"/>
                <input type="button" name="next" class="next action-button btn btn-success" value="Siguiente"/>
            </fieldset>
            <fieldset>
                <div class="form-card">
                    <div class="form-group">
                        <label for="" class="control-label">Número de documento <small>(factura o contrato)</small></label>
                        <input type="text" class="form-control" name="documento" v-model="documento"/>
                        <error-form :attribute_name="'documento'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="">Fecha del documento</label>
                        <input type="date" class="form-control" name="fecha" v-model="fecha" v-validate="'required'"/>
                        <error-form :attribute_name="'fecha'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="">Detalle de la queja</label>
                        <textarea class="form-control" name="detalle" rows="4" v-model="detalle" v-validate="'required'"></textarea>
                        <error-form :attribute_name="'detalle'" :errors_form="errors"></error-form>
                    </div>
                    <div class="form-group">
                        <label for="">Solicito que</label>
                        <textarea class="form-control" name="solicitud" rows="4" v-model="solicitud" v-validate="'required'"></textarea>
                        <error-form :attribute_name="'solicitud'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <input type="button" name="previous" class="previous action-button-previous btn btn-danger" value="Anterior"/>
                <input type="button" name="make_payment" class="next action-button btn btn-success" value="Siguiente"/>
            </fieldset>
            <fieldset>
                <div class="form-card">
                    <table class="table table-bordered">
                        <tr><th colspan="2">Datos del consumidor</th></tr>
                        <tr>
                            <td>Nacionalidad</td>
                            <td>{{ origen == 1 ? 'Guatemalteco' : 'Extranjero'}}</td>
                        </tr>
                        <tr>
                            <td>Teléfono de contacto</td>
                            <td>{{ telefono }}</td>
                        </tr>
                        <tr>
                            <td>Correo de contacto</td>
                            <td>{{ correo }}</td>
                        </tr>
                        <tr>
                            <td>Nombre</td>
                            <td>{{ nombres }} {{ apellidos }}</td>
                        </tr>
                        <tr><th colspan="2">Datos del proveedor</th></tr>
                        <tr>
                            <td>NIT</td>
                            <td>{{ nit }}</td>
                        </tr>
                        <tr>
                            <td>Nombre del empresa</td>
                            <td>{{ negocio }}</td>
                        </tr>
                        <tr>
                            <td>Actividad Economica</td>
                            <td>{{ actividad.text }}</td>
                        </tr>
                        <tr>
                            <td>Municipio</td>
                            <td>{{ municipio.text }}</td>
                        </tr>
                        <tr>
                            <td>Departamento</td>
                            <td>{{ departamento.text }}</td>
                        </tr>
                        <tr><th colspan="2">Datos de la queja</th></tr>
                        <tr>
                            <td>Número de documento</td>
                            <td>{{ documento }}</td>
                        </tr>
                        <tr>
                            <td>Fecha del documento</td>
                            <td>{{ formato_fecha(fecha) }}</td>
                        </tr>
                        <tr>
                            <td>Detalle de la queja</td>
                            <td>{{ detalle }}</td>
                        </tr>
                        <tr>
                            <td>Solicitud</td>
                            <td>{{ solicitud }}</td>
                        </tr>
                    </table>
                </div>
                <div class="row text-center">
                    <div class="col-md-12 text-center">
                        <vue-recaptcha
                            style="display:inline-block;"
                            sitekey="6LcVKbQaAAAAAGfPCyQQEwuehtLvLXnWzf62IoT0"
                            :loadRecaptchaScript="true"
                            @expired="anularRecaptcha"
                            @verify="verificarRecaptcha"></vue-recaptcha>
                    </div>
                </div>
                <input type="button" name="previous" class="previous action-button-previous btn btn-danger" value="Anterior" v-if="mostrarBotones"/>
                <input type="button" name="make_payment" class="btn btn-success" value="Confirmar" @click="validar()" v-if="mostrarBotones && recaptcha"/>
            </fieldset>
        </form>
        <!-- Boleta -->
        <div class="modal fade" id="imprimir-boleta" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Impresión de boleta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <boleta-component v-if="mostrarBoleta" :registro=boleta></boleta-component>
                    </div>
                </div>
            </div>
        </div>
        <!-- End boleta -->
    </div>
</template>

<script>
import moment from 'moment';
import BoletaComponent from './shared/BoletaComponent';
import VueRecaptcha from 'vue-recaptcha';
    export default{
        components:{
            BoletaComponent,
            VueRecaptcha
        },
        data(){
            return {
                loading:false,

                origen:1,//
                telefono:'',
                correo:'',
                nombres:'',
                apellidos:'',
                nit:'',//
                negocio:'',//
                actividad:'',//
                departamento:'',//
                municipio:'',//
                documento:'',
                fecha:'',//
                detalle:'',//
                solicitud:'',//
                direccion:'',

                municipios:[],

                mostrarBoleta:false,
                boleta:{},
                mostrarBotones:true,

                recaptcha:null,
            }
        },
        props:{
            departamentos:{},
            actividades:{}
        },
        mounted(){
            this.config_error()
            $('#imprimir-boleta').on('hidden.bs.modal', function (event) {
                window.location.reload()
            })
        },
        created(){

        },
        methods:{
            verificarRecaptcha(response)
            {
                this.recaptcha = response
            },
            anularRecaptcha()
            {
                this.recaptcha = null
            },
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
                        this.guardar()
                    }
                    else
                    {
                        Toastr.error('Hay campos que faltan por completar','Mensaje')
                    }
                });
            },

            llenar_municipios(){
                this.loading = true
                axios.get(abs_path + '/listado-municipios/'+this.departamento.id)
                    .then(r => {
                        this.loading = false
                        this.municipios = []
                        this.municipios = r.data.data
                    })
                    .catch(error => {
                        this.loading = false
                        Toastr.error(error.response.data.error,'Mensaje')
                    })
            },

            guardar(){
                let data = {
                    'origen':this.origen,
                    'telefono':this.telefono,
                    'correo':this.correo,
                    'nombres':this.nombres,
                    'apellidos':this.apellidos,
                    'nit':this.nit,
                    'negocio':this.negocio,
                    'actividad':this.actividad.id,
                    'departamento':this.departamento.id,
                    'municipio':this.municipio.id,
                    'documento':this.documento,
                    'fecha':this.fecha,
                    'detalle':this.detalle,
                    'solicitud':this.solicitud,
                    'direccion':this.direccion,
                }
                this.loading = true
                axios.post(abs_path + '/guardar-queja', data)
                    .then(r => {
                        Toastr.success(r.data.data,'Mensaje')
                        this.boleta = r.data.registro
                        this.mostrarBotones = false
                        this.mostrarBoleta = true
                        $('#imprimir-boleta').appendTo("body").modal('show');
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
                    origen:{
                        required:'La nacionalidad es requerida',
                    },
                    telefono:{
                        required:'El número de teléfono es requerido',
                        numeric:'El teléfono es un número',
                    },
                    correo:{
                        email:'El correo debe ser válido',
                    },
                    nombres:{
                        required:'El nombre es requerido',
                    },
                    apellidos:{
                        required:'El apellido es requerido',
                    },
                    nit:{
                        required:'El nit es requerido',
                    },
                    negocio:{
                        required:'El nombre es requerido',
                    },
                    actividad:{
                        required:'La actividad es requerida',
                    },
                    departamento:{
                        required:'El departamento es requerido',
                    },
                    municipio:{
                        required:'El municipio es requerido',
                    },
                    documento:{

                    },
                    fecha:{
                        required:'La fecha es requerida',
                        date_format:'La fecha debe ser válida'
                    },
                    detalle:{
                        required:'El detalle es requerido',
                    },
                    solicitud:{
                        required:'La solicitud es requerida',
                    },
                    direccion:{
                        required:'La dirección es requerida',
                    },
                }
               }
              self.$validator.localize('es',dict);
          },
        },
    }
</script>
