<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <form method="POST" autocomplete="off" @submit.prevent="validar">
            <div class="form-group">
                <label for="" class="control-label">Nombre de la región</label>
                <select name="region" id="region" class="form-control" v-validate="'required'" v-model="region">
                    <template v-for="item in regiones">
                        <option :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
                <error-form :attribute_name="'region'" :errors_form="errors"></error-form>
            </div>
            <div class="form-group">
                <label for="">Nombre del departamento</label>
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
                region:'',
            }
        },
        props:{
            regiones:{},
            departamento:{}
        },
        mounted(){
            this.config_error()
        },
        created(){
            if(this.departamento)
            {
                this.id = this.departamento.id
                this.nombre = this.departamento.nombre
                this.region = this.departamento.region_id
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
                    'nombre':this.nombre,
                    'region':this.region,
                }
                this.loading = true
                axios.put(abs_path + '/departamentos/' + this.id, data)
                    .then(r => {
                        this.loading = false
                        Toastr.success(r.data.data,'Mensaje')
                        window.location.href = abs_path + '/departamentos'
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
                  region:{
                      required:'El nombre de la región es requerida'
                  },
                }
               }
              self.$validator.localize('es',dict);
          },
        },
    }
</script>
