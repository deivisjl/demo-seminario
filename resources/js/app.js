/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');

require('./bootstrap');
window.$.fn.DataTable = require( 'datatables.net' );
window.$.fn.DataTable = require( 'datatables.net-bs4' );

window.Swal = require('sweetalert2');
window.Toastr = require('toastr');

require('./utils');

window.abs_path = '';

/* VeeValidate */
import VeeValidate from 'vee-validate';

const VueValidationEs = require('vee-validate/dist/locale/es');

const config = {
  locale: 'es',
  validity: true,
  dictionary: {
    es: VueValidationEs
  },
  fieldsBagName: 'campos',
  errorBagName: 'errors', // change if property conflicts
};

Vue.use(VeeValidate, config);
/* End VeeValidate */

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('error-form', require('./components/shared/ErrorComponent').default);

Vue.component('editar-region-component', require('./components/administrar/region/EditarRegionComponent.vue').default);
Vue.component('nuevo-region-component', require('./components/administrar/region/NuevoRegionComponent.vue').default);

Vue.component('nuevo-departamento-component', require('./components/administrar/departamento/NuevoDepartamentoComponent.vue').default);
Vue.component('editar-departamento-component', require('./components/administrar/departamento/EditarDepartamentoComponent.vue').default);


Vue.component('nuevo-municipio-component', require('./components/administrar/municipio/NuevoMunicipioComponent.vue').default);
Vue.component('editar-municipio-component', require('./components/administrar/municipio/EditarMunicipioComponent.vue').default);

Vue.component('credencial-component', require('./components/administrar/usuario/CredencialComponent.vue').default);
Vue.component('perfil-component', require('./components/administrar/usuario/PerfilComponent.vue').default);
Vue.component('nuevo-usuario-component', require('./components/administrar/usuario/NuevoUsuarioComponent.vue').default);
Vue.component('editar-usuario-component', require('./components/administrar/usuario/EditarUsuarioComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
