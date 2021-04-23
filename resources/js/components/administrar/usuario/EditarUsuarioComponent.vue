<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="post" autocomplete="off" @submit.prevent="validar">
            <div class="form-group">
                <label for="" class="font-weight-bold">Datos personales</label>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Nombres</label>
                        <input type="text" class="form-control" name="nombres" v-model="nombres" v-validate="'required'">
                        <error-form :attribute_name="'nombres'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" v-model="apellidos" v-validate="'required'">
                        <error-form :attribute_name="'apellidos'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">DPI</label>
                        <input type="text" class="form-control" name="dpi" v-model="dpi" v-validate="'required|numeric'">
                        <error-form :attribute_name="'dpi'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" v-model="telefono" v-validate="'required|numeric'">
                        <error-form :attribute_name="'telefono'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Dirección</label>
                <textarea class="form-control" name="direccion" v-model="direccion" v-validate="'required'"></textarea>
                <error-form :attribute_name="'direccion'" :errors_form="errors"></error-form>
            </div>
            <hr>
            <div class="form-group">
                <label for="" class="font-weight-bold">Datos de la cuenta</label>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Rol</label>
                <select name="rol" id="rol" class="form-control" v-validate="'required'" v-model="rol">
                    <template v-for="item in roles">
                        <option :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
                <error-form :attribute_name="'rol'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-block">Editar</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default
    {
        data(){
            return {
                loading:false,
                id:'',
                nombres:'',
                apellidos:'',
                dpi:'',
                telefono:'',
                direccion:'',
                rol:'',
            }
        },
        props:{
            roles:{},
            usuario:{}
        },
        mounted() {
            this.config_error()
        },
        created(){
            if(this.usuario)
            {
                this.id = this.usuario.id,
                this.nombres = this.usuario.nombres,
                this.apellidos = this.usuario.apellidos,
                this.dpi = this.usuario.dpi,
                this.telefono = this.usuario.telefono,
                this.direccion = this.usuario.direccion,
                this.rol = this.usuario.rol_id
            }
        },
        methods:{
            validar(){
                this.$validator.validateAll().then((result) =>{
                        if(result){
                          this.editar();
                        }
                  });
            },
            editar(){
                let data = {
                    'nombres':this.nombres,
                    'apellidos':this.apellidos,
                    'dpi':this.dpi,
                    'telefono':this.telefono,
                    'direccion':this.direccion,
                    'rol':this.rol,
                }
                this.loading = true
                axios.put(abs_path + '/usuarios/'+this.id, data)
                    .then(r => {
                        this.loading = false
                        Toastr.success(r.data.data,'Mensaje')
                        window.location.href = abs_path + '/usuarios'
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
                    nombres:{
                        required:'El nombre es requerido'
                    },
                    apellidos:{
                        required:'El apellido es requerido'
                    },
                    dpi:{
                        required:'El dpi es requerido',
                        numeric:'El dpi es un número'
                    },
                    telefono:{
                        required:'El teléfono es requerido',
                        numeric:'El teléfono es un número'
                    },
                    direccion:{
                        required:'La dirección es requerida'
                    },
                    rol:{
                        required:'El rol es requerido'
                    },
                    email:{
                        required:'El correo electrónico es requerido'
                    },
                  password:{
                      required:'La contraseña es requerida'
                  },
                  password_confirmation:{
                      required:'La confirmación de la contraseña es requerida'
                  }
                }
               }
              self.$validator.localize('es',dict);
          },
        }
    }
</script>
