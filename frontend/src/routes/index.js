import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Settings from '@/pages/settings/settings'
import Profile from '@/pages/profile/profile'

export default [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/:id/:nome?',
    name: 'Profile',
    component: Profile
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/settings',
    name: 'Settings',
    component: Settings
  }
]
