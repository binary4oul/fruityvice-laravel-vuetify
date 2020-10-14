export default [
  ...applyRules(['guest'], [
    { path: '', component: require('$comp/auth/AuthWrapper').default, redirect: { name: 'login' }, children:
      [
        { path: '/login', name: 'login', component: require('$comp/auth/login/Login').default },
        { path: '/register', name: 'register', component: require('$comp/auth/register/Register').default },
        { path: '/password', component: require('$comp/auth/password/PasswordWrapper').default, children:
          [
            { path: '', name: 'forgot', component: require('$comp/auth/password/password-forgot/PasswordForgot').default },
            { path: 'reset/:token', name: 'reset', component: require('$comp/auth/password/password-reset/PasswordReset').default }
          ]
        }
      ]
    },
  ]),
  ...applyRules(['auth'], [
    { path: '', component: require('$comp/page').default, children:
      [
        { path: '', name: 'index', component: require('$comp/page/home').default },
        { path: 'setting', name: 'setting', component: require('$comp/page/shared/Settings').default },
        { path: 'profile', component: require('$comp/page/profile/ProfileWrapper').default, children:
          [
            { path: '', name: 'profile', component: require('$comp/page/profile/Profile').default },
            { path: 'edit', name: 'profile-edit', component: require('$comp/page/profile/edit/ProfileEdit').default }
          ]
        },
        { path: 'lead', component: require('$comp/page/lead/LeadWrapper').default, children:
          [
            { path: 'list/:active', name: 'leads', component: require('$comp/page/lead/LeadList').default },
            { path: 'edit/:leadid', name: 'lead-edit', component: require('$comp/page/lead/LeadEdit').default }
          ]
        },
        { path: 'project', component: require('$comp/page/lead/LeadWrapper').default, children:
          [
            { path: 'estimates/:active', name: 'estimates', component: require('$comp/page/estimate/EstimateList').default },
            { path: 'complete/:active', name: 'complete', component: require('$comp/page/estimate/CompleteProject').default },
            { path: 'current/:active', name: 'current', component: require('$comp/page/estimate/CurrentProject').default },
            { path: 'edit/:leadid', name: 'project-edit', component: require('$comp/page/estimate/ProjectEdit').default },
          ]
        },

        { path: 'color/list', name: 'colors', component: require('$comp/page/more/ColorList').default},
        { path: 'pattern/list', name: 'patterns', component: require('$comp/page/more/PatternList').default},
        { path: 'ingredient/list', name: 'ingredients', component: require('$comp/page/more/IngredientList').default},
        { path: 'ingredient/edit/:ingredientid', name: 'ingredient-edit', component: require('$comp/page/more/IngredientEdit').default},
        { path: 'system/list', name: 'systems', component: require('$comp/page/more/SystemList').default},
        { path: 'system/edit/:systemid', name: 'system-edit', component: require('$comp/page/more/SystemEdit').default},
        { path: 'myteams', name: 'myteams', component: require('$comp/page/more/MyTeam').default},
        { path: 'myteams/project/:teamid', name: 'teamProject', component: require('$comp/page/more/TeamProject').default},
        { path: 'mymembership', name: 'mymembership', component: require('$comp/page/more/MyMembership').default},

      ]
    },

  ]),
  { path: '*', redirect: { name: 'index' } }
]

function applyRules(rules, routes) {
  for (let i in routes) {
    routes[i].meta = routes[i].meta || {}

    if (!routes[i].meta.rules) {
      routes[i].meta.rules = []
    }
    routes[i].meta.rules.unshift(...rules)

    if (routes[i].children) {
      routes[i].children = applyRules(rules, routes[i].children)
    }
  }

  return routes
}
