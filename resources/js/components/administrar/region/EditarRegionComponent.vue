<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="POST" autocomplete="off" @submit.prevent="validar">
            <div class="form-group">
                <label for="">Nombre de la región</label>
                <input type="text" class="form-control" name="nombre" v-validate="'required'" v-model="nombre">
                <error-form :attribute_name="'nombre'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success float-right">Editar</button>
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
            region:{}
        },
        mounted(){
            this.config_error()
        },
        created(){
            if(this.region)
            {
                this.id = this.region.id
                this.nombre = this.region.nombre
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
                    'nombre':this.nombre
                }
                this.loading = true
                axios.put(abs_path + '/regiones/' + this.id, data)
                    .then(r => {
                        this.loading = false
                        Toastr.success(r.data.data,'Mensaje')
                        window.location.href = abs_path + '/regiones'
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
                      required:'El nombre de la región es requerida'
                  },
                }
               }
              self.$validator.localize('es',dict);
          },
        },
    }
</script>
