export default {
	state: {
		all: []
	},
	mutations: {
		getPlaces(state, payload) {
			if(typeof payload.places !== 'undefined') {
				state.all = payload.places
			}
		}
	},
	actions: {
		placesAll(context, payload) {
			context.dispatch('httpRequest', {
				url: '/places',
				method: 'GET',
				mutation: 'getPlaces'
			});
		}
	},
	getters: {

	}	
}