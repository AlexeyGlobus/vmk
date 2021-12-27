export default {
	state: {
		httpErrors: []
	},
	mutations: {
		setHttpErrors(state, payload) {
			state.httpErrors.push(this.$t(payload));
		}
	},
	actions: {
		httpRequest(context, payload) {
			if (typeof payload === 'object') {
				let url = payload.url;
				let method = payload.method;
				let data = payload.data;
				let mutation = payload.mutation;
				if (typeof url === 'string' && url.length && 
					typeof method === 'string' && method.length &&
					typeof method === 'string' && method.length) {
					axios({method, url,data})
              		.then(response => {
		                if (response.status >= 200 && response.status < 300) {
		                        return response;
		                    } else {
		                        let error = new Error(response.statusText);
		                        error.response = response;
		                        throw error
		                    }
		                }).then(response => {
		                    if (response.headers['content-type'] !== 'application/json') {
		                        let error = new Error('Некорректный ответ от сервера');
		                        error.response = response;
		                        throw error
		                    }
		                    return response.data;
		                }).then(json => {
		                	context.commit(mutation, json);
		                }).catch(error => {
		                     if (typeof error.message !== 'undefined') {
		                        context.commit('setHttpErrors', error.message);
		                     }
		                });
		        	}
				}	
			}
		},
	getters: {
	}	
}