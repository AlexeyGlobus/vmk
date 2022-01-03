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
		async placesAll(context, payload) {
			return context.dispatch('httpRequest', {
				url: '/places',
				method: 'GET',
				mutation: 'getPlaces'
			});
		}
	},
	getters: {
		placeById: state => id => {
			if(typeof state.all === 'object' && !!state.all.length) {
				return state.all.find(place => {
					return place.id == id
				})
			} else {
				return null;
			}
		}
	}	
}