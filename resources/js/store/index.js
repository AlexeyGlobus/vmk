import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);
import http from './http';
import places from './places';

export default new Vuex.Store({
	modules: {
		http,
		places
	}
})