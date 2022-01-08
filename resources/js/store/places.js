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
		},
		updatePlaces(state, payload) {
			if (typeof payload.place === 'object' && !_.isEmpty(payload.place) && typeof state.all === 'object') {
				let newRecord = true;
				state.current = payload.place;
				if (!!state.all.length) {
					state.all.forEach((item, i, arr) => {
						if (item.id == payload.id) {
							newRecord = false;
							state.all[i] = payload;
						}
					});
				}
				if (newRecord) {
					state.all.push(payload);
				}
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
			let place = null;
			if(typeof state.all === 'object' && !!state.all.length) {
				place = state.all.find(place => {
					return place.id == id
				});
				if (typeof place === 'object' && typeof place.coords === 'object' && place.coords.length === 2) {
					return place;
				}
	            if (typeof place === 'object' && typeof place.coords === 'string' && !!place.coords.length) {
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
	            	place = {};
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