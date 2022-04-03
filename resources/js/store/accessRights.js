export default {
	state: {
		user: {},
		all: [],
		roles: {
			'1': 'Administrator',
			'2': 'Accountant',
			'3': 'Director',
			'4': 'User'
		},
		tables: {
			'access_rights': 'Access Rights',
			'places': 'Places'
		}
	},
	mutations: {
		setUser(state, payload) {
			state.user = payload;
		},
		setAccessRights(state, payload) {
			if(typeof payload.access_rights !== 'undefined') {
				state.all =  payload.access_rights;
			}
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
		},
		roleName: state => roleId => {
			return typeof state.roles[roleId] === 'string' ? state.roles[roleId] : roleId;
		},
		tableName: state => tableName => {
			return typeof state.tables[tableName] === 'string' ? state.tables[tableName] : tableName;
		}
	}
}