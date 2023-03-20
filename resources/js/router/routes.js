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
        { path: 'fruits', component: require('$comp/page/fruit/FruitWrapper').default, children:
          [
            { path: 'list', name: 'all-fruits', component: require('$comp/page/fruit/FruitList').default }
          ]
        },
        { path: 'favourites', component: require('$comp/page/fruit/FruitWrapper').default, children:
          [
            { path: 'list', name: 'favourites', component: require('$comp/page/favourite/FavouriteList').default },
          ]
        },
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
