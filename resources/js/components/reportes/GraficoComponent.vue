<template>
    <div>
        <div class="block-loading" v-if="loading"></div>
        <div class="row justify-content-center">
            <div class="col-md-8">
            <form class="form-inline" @submit.prevent="validar()">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="fecha desde" class="">Fecha desde</label>
                    <input type="date" class="form-control" name="desde" v-model="valorFechaInicio">
                    </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="fecha hasta" class="">Fecha hasta</label>
                    <input type="date" class="form-control" name="hasta" v-model="valorFechaFin">
                </div>
                <button type="submit" class="btn btn-primary mb-2">Generar reporte</button>
                </form>
            </div>
        </div>
        <!--  -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mb-3" style="max-width: 540px;border: 2px solid #007bff">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                        <img src="../../../img/diaco-logo.png" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-success font-weight-bold">Total quejas recibidas</h5>
                                <p class="card-text"><h1>{{ totalQuejas }}</h1></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="row">
            <div class="col-md-6">
                <GChart
                    type="PieChart"
                    :data="chartData"
                    :options="chartOptions"
                    style="width: auto; height: 350px;"
                    />
            </div>
            <div class="col-md-6">
                <GChart
                    type="PieChart"
                    :data="chartDataDeptos"
                    :options="chartOptionsDeptos"
                    style="width: auto; height: 350px;"
                    />
            </div>
        </div>
        <!--  -->
        <div class="row">
            <div class="col-md-6">
                <GChart
                    type="ColumnChart"
                    :data="chartDataTop5"
                    :options="chartOptionsTop5"
                    style="width: auto; height: 350px;"
                    />
            </div>
            <div class="col-md-6">
                <GChart
                    type="ColumnChart"
                    :data="chartDataTop5Actividad"
                    :options="chartOptionsTop5Actividad"
                    style="width: auto; height: 350px;"
                    />
            </div>
        </div>
        <!--  -->
        <div class="row">
            <div class="col-md-12">
                <GChart
                    type="BarChart"
                    :data="chartDataTop10"
                    :options="chartOptionsTop10"
                    style="width: auto; height: 350px;"
                    />
            </div>
        </div>
        <!--  -->
    </div>
</template>
<script>
import { GChart } from "vue-google-charts";
import moment from 'moment';
export default{
        components:{
            GChart,
        },
        data(){
            return {
                loading:false,
                valorFechaInicio:null,
                valorFechaFin:null,

                totalQuejas:'',

                chartData: [["Región", "Quejas"],],
                chartOptions: {},

                chartDataDeptos : [["Departamento", "Quejas"],],
                chartOptionsDeptos : {},

                chartDataTop5:[["Entidad", "Quejas"],["", 0],],
                chartOptionsTop5:{},

                chartDataTop5Actividad:[["Actividad económica", "Quejas"],["", 0],],
                chartOptionsTop5Actividad:{},

                chartDataTop10:[["Municipio", "Quejas"],["", 0],],
                chartOptionsTop10:{},
            }
        },
        props:{
            departamentos:{},
            actividades:{}
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

            totalQuejasRecibidas()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }

                    axios.post(abs_path + '/reporte-grafico-total-quejas',data)
                        .then((r) => {
                            this.totalQuejas = r.data.data
                        })
                        .catch(error => {

                        })
            },
            llenar_graficos_region()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }

                    axios.post(abs_path + '/reporte-grafico-por-region',data)
                        .then((r) => {

                            if(r.data.data.length >= 1)
                            {
                                this.chartOptions = {
                                    //legend: 'none',
                                    title:'Quejas por regiones',
                                    is3D: true,
                                }
                                this.chartData = r.data.data
                            }
                        })
                        .catch(error => {

                        })
            },

            llenar_graficos_departamento()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }

                    axios.post(abs_path + '/reporte-grafico-por-departamento',data)
                        .then((r) => {

                            if(r.data.data.length >= 1)
                            {
                                this.chartOptionsDeptos = {
                                    title:'Quejas por departamentos',
                                    pieHole: 0.4,
                                }
                                this.chartDataDeptos = r.data.data
                            }
                        })
                        .catch(error => {

                        })
            },

            llenar_graficos_top5()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }

                    axios.post(abs_path + '/reporte-grafico-top5',data)
                        .then((r) => {

                            if(r.data.data.length >= 1)
                            {
                                this.chartOptionsTop5 = {
                                    title:'Top 5 entidades o negocios con más quejas',
                                }
                                this.chartDataTop5 = r.data.data
                            }
                        })
                        .catch(error => {

                        })
            },
            llenar_graficos_top5_actividad()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }

                    axios.post(abs_path + '/reporte-grafico-top5-actividad',data)
                        .then((r) => {

                            if(r.data.data.length >= 1)
                            {
                                this.chartOptionsTop5Actividad = {
                                    title:'Top 5 categorías con más quejas',
                                }
                                this.chartDataTop5Actividad = r.data.data
                            }
                        })
                        .catch(error => {

                        })
            },
            llenar_graficos_top10()
            {
                let data = {
                        'desde' : this.valorFechaInicio,
                        'hasta' : this.valorFechaFin,
                    }

                    axios.post(abs_path + '/reporte-grafico-top10',data)
                        .then((r) => {

                            if(r.data.data.length >= 1)
                            {
                                this.chartOptionsTop10 = {
                                    title:'Top 10 municipios donde se ubican las quejas',
                                     hAxis: {
                                        title: 'Total Quejas',
                                        minValue: 0
                                    },
                                        vAxis: {
                                        title: 'Municipios'
                                    }
                                }
                                this.chartDataTop10 = r.data.data
                            }
                        })
                        .catch(error => {

                        })
            },
             validar(){

                 this.llenar_graficos_region()
                 this.llenar_graficos_departamento()
                 this.llenar_graficos_top5()
                 this.llenar_graficos_top5_actividad()
                 this.llenar_graficos_top10()
                 this.totalQuejasRecibidas()
                 /* Promise.all([this.llenar_graficos()])
                    .then(r => {
                        this.loading = false
                    })
                    .catch(error =>{
                        this.loading = false
                    }) */

                /* let inicio = moment(this.valorFechaInicio,"DD-MM-YYYY")
                let fin = moment(this.valorFechaFin,"DD-MM-YYYY") */

                /* if(inicio <= fin)
                {
                    Toastr.success('El rango de fechas es válida','Mensaje')
                    console.log(inicio)
                    console.log(fin)
                }
                else
                {
                    Toastr.error('El rango de fechas debe ser válida','Mensaje')
                    console.log(inicio)
                    console.log(fin)
                } */
            },
        },
    }
</script>

