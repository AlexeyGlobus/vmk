export default {
	state: {
		all: [],
		current: {}
	},
	mutations: {
		getPlaces(state, payload) {
			if(typeof payload.places !== 'undefined') {
				state.all = payload.places
			}
			if(typeof payload.current !== 'undefined') {
				state.current = payload.current
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
			let place = {};
			if(typeof state.all === 'object' && !!state.all.length) {
				place = state.all.find(place => {
					return place.id == id
				});
				if (typeof place.coords === 'object' && place.coords.length === 2) {
					return place;
				}
	            if (typeof place.coords === 'string' && !!place.coords.length) {
	              let coords = place.coords.match(/\d+\.*\d*/g);
	              if (!!coords && typeof coords === 'object') {
		              	coords.forEach((x, i) => {
		                coords[i] = parseFloat(x);
		              });
		              place.coords = coords;
	              } else {
	              	place.coords = [];
	              }
	            } else {
	              //place = {};
	              place.coords = [];
	            }
			}
			return place;
		},
		currentId(state) {
			return typeof state.current.id !== 'undefined' ? state.current.id : null;
		}
	}	
}