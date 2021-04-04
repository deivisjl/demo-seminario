<template>
    <div>
        <form action="#" autocomplete="off"  @submit.prevent="validar">
            <div class="row">
                <div class="col-md-12 text-center">
                    <img src="/images/account.png" alt="" class="img-circle" style="height: 100px;">
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>{{ email }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Nombres</label>
                        <input type="text" class="form-control" name="nombres" v-model="nombres" v-validate="'required'">
                        <error-form :attribute_name="'nombres'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" v-model="apellidos" v-validate="'required'">
                        <error-form :attribute_name="'apellidos'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">DPI</label>
                        <input type="text" class="form-control" name="dpi" v-model="dpi" v-validate="'required|numeric'">
                        <error-form :attribute_name="'dpi'" :errors_form="errors"></error-form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Teléfono</label>
                        <input type="text" class="form-control" name="telefono" v-model="telefono" v-validate="'required|numeric'">
                        <error-form :attribute_name="'telefono'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">Dirección</label>
                        <textarea name="direccion" class="form-control" v-model="direccion" v-validate="'required'"></textarea>
                        <error-form :attribute_name="'direccion'" :errors_form="errors"></error-form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success btn-block">Editar perfil</button>
                </div>
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
                email:'',
            }
        },
        props:{
            perfil:{}
        },
        mounted() {
            this.config_error()
        },
        created(){
            if(this.perfil)
            {
                this.nombres = this.perfil.nombres
                this.apellidos = this.perfil.apellidos
                this.dpi = this.perfil.dpi
                this.telefono = this.perfil.telefono
                this.direccion = this.perfil.direccion
                this.email = this.perfil.email
            }
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
                    'direccion':this.direccion
                }
                this.loading = true
                axios.post(abs_path + '/perfil',data)
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
                    nombres:{
                         required:'El nombre es requerido'
                    },
                    apellidos:{
                        required:'El apellido es requerido'
                    },
                    dpi:{
                        required:'El DPI es requerido',
                        numeric:'El DPI es un número'
                    },
                    telefono:{
                        required:'El teléfono es requerido',
                        numeric:'El teléfono es un número'
                    },
                    direccion:{
                        required:'La dirección es requerida'
                    }
                }
               }
              self.$validator.localize('es',dict);
          },
        }
    }
</script>
