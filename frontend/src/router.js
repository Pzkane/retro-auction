import VueRouter from 'vue-router'

import Home from './views/Home.vue'
import Offers from './views/Offers.vue'
import Auction from './views/Auction.vue'
import Registration from './views/Registration.vue'
import Dashboard from './views/Dashboard.vue'
import AdminDashboard from './views/admin/ControlPanel.vue'
import SADashboard from './views/admin/su/Dashboard.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/offers',
    name: 'offers',
    component: Offers
  },
  {
    path: '/auction',
    name: 'auction',
    component: Auction
  },
  
  //auth forms
  {
    path: '/signup',
    name: 'signup',
    component: Registration,
    meta: {
      auth: false
    }
  },

  //user routes
  {
    path: '/dashboard',
    name: 'dashboard',
    component: Dashboard,
    meta: {
      auth: true
    },
  },

  //admin routes
  {
    path: '/admin',
    name: 'admin.dashboard',
    component: AdminDashboard,
    meta: {
      auth: {roles: ['super_admin', 'admin'], redirect: {name: 'offers'}, forbiddenRedirect: '/403'}
    },
  },

  //super admin
  {
    path: '/sadmin',
    name: 'sadmin.dashboard',
    component: SADashboard,
    meta: {
      auth: {roles: 'super_admin', redirect: {name: 'offers'}, forbiddenRedirect: '/403'}
    },
  }
]
const router = new VueRouter({
  history: true,
  mode: 'history',
  routes,
})

export default router
