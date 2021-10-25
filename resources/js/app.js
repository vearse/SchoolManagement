require('./bootstrap');
require('jquery');

window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform';
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';
import Route from './route';
import swal from 'sweetalert2';
import FullCalendar from '@fullcalendar/vue';
import interactionPlugin from '@fullcalendar/interaction';
window.swal = swal;  
// import  from 'vuetify-material-dashboard'
if(window.user) window.calendar =  window.user.calendar;


Vue.use(Vuetify);
Vue.use(VueRouter);
Vue.use(FullCalendar);

const toast = swal.mixin({  
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 6000
});

window.toast = toast;
window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('FullCalendar', FullCalendar);
Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('new-applicant', require('./components/NewApplicant.vue'));
Vue.component('new-student', require('./components/NewStudent.vue'));
Vue.component('complex-component', require('./components/ComplexComponent.vue'));

// import SearchWidget from './widgets/SearchWidget.vue';
// import MenuWidget from './widgets/MenuWidget.vue';
// import StudentMenu from './widgets/StudentSidebar.vue';
// import ManagerMenu from './widgets/ManagerSidebar.vue'; 
Vue.component('menu-school',  require('./widgets/MenuWidget.vue'));
Vue.component('course-timetable',  require('./widgets/CourseTimetable.vue'));
Vue.component('search-school', require('./widgets/SearchWidget.vue'));
Vue.component('student-menu', require('./widgets/StudentSidebar.vue') );
Vue.component('manager-menu', require('./widgets/ManagerSidebar.vue'));
Vue.component('not-found',  require('./components/NotFound.vue'));

Vue.filter('storeDir', function(value){ 
  if(value) return value.replace('public', 'storage');
});
const router = new VueRouter({ 
    // base: '/school/public',
    base: '/',
    mode: 'history', 
    routes: Route.routes
})

const vuetifyopts = {}
export default {
    components: {
      FullCalendar // make the <FullCalendar> tag available
    },
}
const app = new Vue({
    el: '#app',
    router,
    data() {
      return {
        // calendarPlugins: [ dayGridPlugin ]
      }
    },
    vuetify: new Vuetify(vuetifyopts)
});
