// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import {router} from './plugins/vue-router'
import axios from "axios";
import Vuex from 'vuex';

Vue.use(Vuex)

Vue.config.productionTip = false
Vue.prototype.$http = axios
Vue.prototype.$urlApi = `http://127.0.0.1:8000/api/`

var store = {
	state:{
		user: sessionStorage.getItem("user") ? JSON.parse(sessionStorage.getItem("user")) : null,
		contentsTimeline: [] 
	},
	getters:{
		getUser: state =>{
			return state.user;
		},
		getToken: state=>{
			return state.user.token;
		},
		getContentsTimeline: state=>{
			return state.contentsTimeline;
		}

	},
	mutations:{
		setUser(state, n) {
			return state.user = n;
		},
		setContentsTimeline(state, n){
			return state.contentsTimeline = n;		
		},
		setPaginationContentsTimeline(state, list){	
			for(let item of list){
				state.contentsTimeline.push(item);
			}
		}
	}


}

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store: new Vuex.Store(store),
  router,
  template: '<App/>',
  components: { App }
})
