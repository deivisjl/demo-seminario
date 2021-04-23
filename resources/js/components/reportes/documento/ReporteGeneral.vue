<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Descargar reporte general</h3>
                    <form @submit.prevent="validar()">
                        <div class="form-group">
                            <label for="fecha desde" class="">Fecha desde</label>
                            <input type="date" class="form-control" name="desde" v-model="valorFechaInicio">
                            </div>
                        <div class="form-group">
                            <label for="fecha hasta" class="">Fecha hasta</label>
                            <input type="date" class="form-control" name="hasta" v-model="valorFechaFin">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-block btn btn-success mb-2">Generar reporte</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default{
        components:{

        },
        data(){
            return {
                loading:false,
                valorFechaInicio:null,
                valorFechaFin:null,
            }
        },
        props:{

        },
        mounted(){

        },
        created(){
            this.setear_fechas()
        },
        methods:{
            setear_fechas()
            {
                this.valorFechaInicio = moment().subtract(6, 'months').format('YYYY-MM-DD');
                this.valorFechaFin = moment().format('YYYY-MM-DD')
            },

            validar()
            {
                this.descargar_reporte()
            },

            descargar_reporte()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }
                    this.loading = true

                    axios.post(abs_path + '/reporte-pdf-general',data)
                        .then((r) => {
                            const blob = new Blob([r.data], {type: r.data.type});
                            const url = window.URL.createObjectURL(blob);
                            const link = document.createElement('a');
                            link.href = url;
                            let fileName = Date.now()+'.pdf';
                            link.setAttribute('download', fileName);
                            document.body.appendChild(link);
                            link.click();
                            link.remove();
                            window.URL.revokeObjectURL(url);
                        })
                        .catch(error => {
                            if(error.response.data.code === 423)
                            {
                                for (let value of Object.values(error.response.data.error)) {
                                    Toastr.error(value, 'Mensaje')
                                }
                                return
                            }
                            Toastr.error(error,'Mensaje')
                        })
                        .finally(() =>{
                            this.loading = false
                        })
            },
        },
    }
</script>
