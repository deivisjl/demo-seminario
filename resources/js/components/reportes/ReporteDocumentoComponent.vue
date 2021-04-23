<template>
    <div>
        <div class="row">
            <div class="col-5">
                <div class="list-group" id="list-tab" role="tablist">
                    <template v-for="item in items">
                        <a class="list-group-item list-group-item-action" v-bind:class="{'active' : item.activo }" id="list-home-list" data-toggle="list"  href="#" role="tab" aria-controls="home" @click="mostrar_componentes(item.no)">{{ item.titulo }}</a>
                    </template>
                </div>
            </div>
            <div class="col-7">
                <reporte-general v-if="reporte_general"></reporte-general>
                <reporte-municipio v-if="reporte_municipio"></reporte-municipio>
                <reporte-negocio v-if="reporte_negocio"></reporte-negocio>
                <reporte-actividad v-if="reporte_actividad"></reporte-actividad>
            </div>
        </div>
    </div>
</template>
<script>
import ReporteGeneral from './documento/ReporteGeneral'
import ReporteMunicipio from './documento/ReporteMunicipio'
import ReporteNegocio from './documento/ReporteNegocio'
import ReporteActividad from './documento/ReporteActividad'
export default{
        components:{
            ReporteGeneral,
            ReporteMunicipio,
            ReporteNegocio,
            ReporteActividad,
        },
        data(){
            return {
                items: [
                    { activo: true, titulo: 'Reporte de quejas general', no: 1},
                    { activo: false, titulo: 'Reporte de quejas por municipio', no: 2},
                    { activo: false, titulo: 'Reporte de quejas por negocio', no: 3 },
                    { activo: false, titulo: 'Reporte de quejas por actividad económica', no: 4 },
                ],

                reporte_general:true,
                reporte_municipio:false,
                reporte_negocio:false,
                reporte_actividad:false,
            }
        },
        created(){

        },
        methods:{

            mostrar_componentes(no)
            {
                switch(no)
                {
                    case 1:
                        this.reporte_general = true
                        this.reporte_municipio = false
                        this.reporte_negocio = false
                        this.reporte_actividad = false
                        break;
                    case 2:
                        this.reporte_general = false
                        this.reporte_municipio = true
                        this.reporte_negocio = false
                        this.reporte_actividad = false
                        break;
                    case 3:
                        this.reporte_general = false
                        this.reporte_municipio = false
                        this.reporte_negocio = true
                        this.reporte_actividad = false
                        break;
                    case 4:
                        this.reporte_general = false
                        this.reporte_municipio = false
                        this.reporte_negocio = false
                        this.reporte_actividad = true
                        break;
                }
            },
        },
    }
</script>
