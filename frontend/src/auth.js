import bearer from '@websanova/vue-auth/drivers/auth/bearer.js'
import authaxios from '@websanova/vue-auth/drivers/http/axios.1.x'
import authrouter from '@websanova/vue-auth/drivers/router/vue-router.2.x.js'

const config = {
  auth: bearer,
  http: authaxios,
  router: authrouter,
  tokenDefaultName: 'laravel-vue-spa',
  tokenStore: ['localStorage'],
  rolesVar: 'role',
  registerData: {url: 'http://127.0.0.1:8000/api/auth/register', method: 'POST', redirect: ''},
  loginData: {url: 'http://127.0.0.1:8000/api/auth/login', method: 'POST', redirect: '', fetchUser: true},
  logoutData: {url: 'http://127.0.0.1:8000/api/auth/logout', method: 'POST', redirect: '/', makeRequest: true},
  fetchData: {url: 'http://127.0.0.1:8000/api/auth/user', method: 'GET', enabled: true},
  refreshData: {url: 'http://127.0.0.1:8000/api/auth/refresh', method: 'GET', enabled: true, interval: 30}
}

export default config