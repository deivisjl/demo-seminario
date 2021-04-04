<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="POST" autocomplete="off" @submit.prevent="validar">
            <div class="form-group">
                <label for="" class="control-label">Nombre del departamento</label>
                <select name="departamento" id="departamento" class="form-control" v-validate="'required'" v-model="departamento">
                    <template v-for="item in departamentos">
                        <option :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
                <error-form :attribute_name="'departamento'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <label for="">Nombre del municipio</label>
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
                departamento:'',
            }
        },
        props:{
            departamentos:{}
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
                    'nombre':this.nombre,
                    'departamento':this.departamento,
                }
                this.loading = true
                axios.post(abs_path + '/municipios', data)
                    .then(r => {
                        this.loading = false
                        Toastr.success(r.data.data,'Mensaje')
                        window.location.href = abs_path + '/municipios'
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
                      required:'El nombre del municipio es requerido'
                  },
                  departamento:{
                      required:'El nombre del departamento es requerido'
                  },
                }
               }
              self.$validator.localize('es',dict);
          },
        },
    }
</script>
