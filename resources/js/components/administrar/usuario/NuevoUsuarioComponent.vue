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
                <label for="" class="control-label">Correo electrónico</label>
                <input type="email" class="form-control" name="email" v-model="email" v-validate="'required'">
                <error-form :attribute_name="'email'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <label class="control-label">Contraseña</label>
                <input type="password" class="form-control" name="password" v-model="password" v-validate="'required'">
                <error-form :attribute_name="'password'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <label for="Repertir contraseña" class="control-label">Repertir contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" v-model="password_confirmation" v-validate="'required'">
                <error-form :attribute_name="'password_confirmation'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Guardar</button>
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
                nombres:'',
                apellidos:'',
                dpi:'',
                telefono:'',
                direccion:'',
                rol:'',
                email:'',
                password:'',
                password_confirmation:''
            }
        },
        props:{
            roles:{}
        },
        mounted() {
            this.config_error()
        },
        created(){

        },
        methods:{
            validar(){
                this.$validator.validateAll().then((result) =>{
                        if(result){
                          this.guardar();
                        }
                  });
            },
            guardar(){
                let data = {
                    'nombres':this.nombres,
                    'apellidos':this.apellidos,
                    'dpi':this.dpi,
                    'telefono':this.telefono,
                    'direccion':this.direccion,
                    'rol':this.rol,
                    'email':this.email,
                    'password':this.password,
                    'password_confirmation':this.password_confirmation
                }
                this.loading = true
                axios.post(abs_path + '/usuarios',data)
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
