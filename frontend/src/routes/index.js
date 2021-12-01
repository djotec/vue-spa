import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Profile from '@/pages/profile/Profile'
import Settings from '@/pages/settings/Settings'

export default [
  {
    path: '/',
    name: 'Home',
    component: Home
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
  },
  {
    path: '/:id/:nome?',
    name: 'Profile',
    component: Profile
  },  
 
  
]
