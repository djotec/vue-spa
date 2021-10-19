import Home from '@/pages/home/Home'
import Login from '@/pages/login/Login'
import Profile from '@/pages/profile/Profile'

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
    path: '/profile',
    name: 'Profile',
    component: Profile
  }
]
