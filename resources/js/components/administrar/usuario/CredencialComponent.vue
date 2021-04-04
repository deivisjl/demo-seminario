<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="post" autocomplete="off" @submit.prevent="validar">
            <div class="form-group">
                <label for="" class="control-label">Nueva contraseña</label>
                <input type="password" class="form-control" name="password" v-validate="'required'" v-model="password">
                <error-form :attribute_name="'password'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Repetir contraseña</label>
                <input type="password" class="form-control" name="password_confirmation" v-validate="'required'" v-model="password_confirmation">
                <error-form :attribute_name="'password_confirmation'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Guardar</button>
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
                password:'',
                password_confirmation:''
            }
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
                    'password':this.password,
                    'password_confirmation':this.password_confirmation
                }
                this.loading = true
                axios.post(abs_path + '/cambiar-credencial',data)
                    .then(r => {
                        this.loading = false
                        Toastr.success(r.data.data,'Mensaje')
                        window.location.href = abs_path + '/home'
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
