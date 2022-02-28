import Vue from 'vue'
import Vuex from 'vuex'
import Router from 'vue-router'
import store from '../store/index'
import App from './App.vue'
import Settings from './components/pages/Settings.vue'
import TabNavigation from './components/tabs/Navigation.vue'
import GeneralStudent from './components/tabs/GeneralStudent.vue'
import Subject from './components/tabs/Subject.vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

Vue.use( Vuex )
Vue.use( Router )
Vue.use(ElementUI)

const routes = [
    {
        path: '/', components: { default: GeneralStudent, tab: TabNavigation },
    },
    {
        path: '/another', components: { default: Subject, tab: TabNavigation },
    },
    {
        path: '/settings', components: { default: Settings },
    },
]

const router = new VueRouter({
    routes,
})

new Vue({
    el: '#wpvk-admin-app',
    store,
    router,
    render: h => h( App )
})