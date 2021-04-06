<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="POST" autocomplete="off" @submit.prevent="validar">
            <div class="form-group">
                <label for="">Nombre de la actividad</label>
                <input type="text" class="form-control" name="nombre" v-validate="'required'" v-model="nombre">
                <error-form :attribute_name="'nombre'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Guardar</button>
            </div>
        </form>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                loading:false,
                id:'',
                nombre:'',
            }
        },
        props:{

        },
        mounted(){
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
                    'nombre':this.nombre
                }
                this.loading = true
                axios.post(abs_path + '/actividad-economica', data)
                    .then(r => {
                        this.loading = false
                        Toastr.success(r.data.data,'Mensaje')
                        window.location.href = abs_path + '/actividad-economica'
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
                  nombre:{
                      required:'El nombre de la actividad es requerida'
                  },
                }
               }
              self.$validator.localize('es',dict);
          },
        },
    }
</script>
