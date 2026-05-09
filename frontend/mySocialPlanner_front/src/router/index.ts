import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  scrollBehavior(_to, _from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }

    return { left: 0, top: 0 }
  },
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/login',
      name: 'Login',
      component: () => import('@/views/LoginView.vue'),
    },
    {
      path: '/register',
      name: '/register',
      component: () => import('@/views/RegisterView.vue'),
    },
    {
      path: '/calendar',
      name: '/calendar',
      component: () => import('@/views/CalendarView.vue'),
    },
    {
      path: '/calendario/:eventId?',
      name: 'Calendario',
      component: () => import('@/views/CalendarView.vue'),
    },
    {
      path: '/MyEvents',
      name: 'myEvents',
      component: () => import('@/views/MyEvents.vue'),
    },
    {
      path: '/MyProfile',
      name: 'myProfile',
      component: () => import('@/views/MyProfile.vue'),
    },
  ],
})

export default router
