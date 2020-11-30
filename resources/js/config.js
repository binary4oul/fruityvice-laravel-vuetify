const siteUrl = Laravel.siteUrl,
  apiUrl = Laravel.apiUrl

export const settings = {
  siteName: Laravel.siteName
}

class URL {
  constructor(base) {
    this.base = base
  }

  path(path, args) {
    path = path.split('.')
    let obj = this,
      url = this.base

    for (let i = 0; i < path.length && obj; i++) {
      if (obj.url) {
        url += '/' + obj.url
      }

      obj = obj[path[i]]
    }
    if (obj) {
      url = url + '/' + (typeof obj === 'string' ? obj : obj.url)
    }

    if (args) {
      for (let key in args) {
        url = url.replace(':' + key, args[key])
      }
    }

    return url
  }
}

export const api = Object.assign(new URL(apiUrl), {
  url: '',

  login: {
    url: 'login',
    refresh: 'refresh'
  },

  logout: 'logout',

  register: 'register',

  password: {
    url: 'password',
    forgot: 'email',
    reset: 'reset'
  },

  me: 'me',

  users: {
    url: 'users',
    activate: ':id/activate',
    single: ':id',
    restore: ':id/restore'
  },

  profile: {
    url: 'profile'
  },

  leads: { url: 'leads' },
  lead: {url: 'lead'},
  person: { url: 'person' },
  phone: { url: 'phone', refresh: 'refresh' },
  address: { url: 'address' },
  states: { url: 'states' },
  leaddetail: { url: 'leaddetail' },
  colors: { url: 'colors' },
  color: {url: 'color'},
  patterns: { url: 'patterns' },
  pattern: {url: 'pattern'},
  ingredients: {url: 'ingredients'},
  ingredient: {url: 'ingredient'},
  systems: {url: 'systems'},
  system: {url: 'system'},
  project: {url: 'project'},
  projectlist: {url: 'projects'},
  projectdetail: {url: 'projectdetail'},
  projectnote: {url: 'project/note'},
  projectimage: {url: 'project/image'},
  projectnotelist: {url: 'project/note/list'},
  projectimagelist: {url: 'project/image/list'},
  getProjectByLeadId: {url: 'project/getbyleadid'},
  getProjectsByStatus: {url: 'project/getprojectsbystatus'},
  getByLeadIdProjectStatus: {url: 'project/getbyleadidprojectstatus'},
  team: {url: 'team'},
  getTeams: {url: 'teams'},
  getTeamProject: {url: 'team/project'},
  getMembers: {url: 'teammembers'},
  teamMember: {url: 'teammember'},
  sendEstimate: {url: 'sendestimate'},

})
