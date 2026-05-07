import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
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
      component: ()=> import('@/views/RegisterView.vue'),
    },
    {
      path: '/calendar',
      name:'/calendar',
      component: ()=> import("@/views/CalendarView.vue"),
    },
    {
      path: '/MyEvents',
      name:'/myEvents',
      component: ()=> import("@/views/MyEvents.vue"),
    },
  ],
})

export default router
