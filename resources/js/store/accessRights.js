export default {
	state: {
		user: {}
	},
	mutations: {
		setUser(state, payload) {
			state.user = payload;
		},
		setAccessRights(state, payload) {

		}
	},
	actions: {
		async accessRightsAll(context, payload) {
			return context.dispatch('httpRequest', {
				url: '/access-rights',
				method: 'GET',
				mutation: 'setAccessRights'
			});
		}
	},
	getters: {
		userCan: state => abilities => {
			let result = false;
			if(typeof state.user.access_rights === 'object' && state.user.access_rights.length) {
				if (typeof abilities === 'string' && abilities.length) {
					let parts = abilities.split('-');
					if(parts.length === 2 && typeof parts === 'object') {
						let tableRighs = state.user.access_rights.filter(r => {
							return r['table_name'] === parts[1];
						});
						if(typeof tableRighs[0] === 'object' && typeof tableRighs[0].rights === 'object') {
							result = tableRighs[0]['rights'][parts[0]];
						}
					}
				}
			}
			return result;
		}
	}
}