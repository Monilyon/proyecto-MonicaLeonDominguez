<script setup lang="ts">
import { ref } from 'vue';
import logo from '@/assets/LogoHorizontal.png';
import { useAuth } from '@/composables/useAuth';

const { isLoggedIn, user, logout } = useAuth();

// Control del menú lateral en móvil
const drawer = ref(false);
const showLogoutDialog = ref(false);

const menuItems = [
  { title: 'Inicio', to: '/', icon: 'mdi-home' },
  { title: 'Calendario', to: '/calendar', icon: 'mdi-calendar' },
  { title: 'Mis eventos', to: '/MyEvents', icon: 'mdi-calendar-check' },
];
const confirmLogout = () => {
  showLogoutDialog.value = false;
  logout();
};
</script>

<template>
  <!-- Menú lateral para version móvil -->
  <v-navigation-drawer v-model="drawer" temporary location="left" style="background-color: #D1D9C1;">
    <v-list>
      <v-list-item v-for="item in menuItems" :key="item.title" :to="item.to" :prepend-icon="item.icon">
        <v-list-item-title>{{ item.title }}</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>

  <v-app-bar v-if="isLoggedIn" color="#D1D9C1" elevation="2">
    <!-- Icono Hamburguesa-->
    <v-app-bar-nav-icon class="d-md-none" @click="drawer = !drawer" />

    <v-img :src="logo" style="max-width: 100px; margin-left: 2%;" />

    <v-spacer />

    <!-- navbar para desktop y tablet-->
    <div class="d-none d-md-flex">
      <v-btn v-for="item in menuItems" :key="item.title" variant="text" :to="item.to">
        {{ item.title }}
      </v-btn>
    </div>

    <v-spacer />

    <div class="d-flex align-center gap-3">
      <div class="text-right mr-3 d-none d-sm-block">
        <div class="text-caption">
          Hola, <strong>{{ user?.name }}</strong>
        </div>
      </div>

      <div class="d-flex align-center mr-4">
        <v-menu min-width="150px" rounded="lg">
          <template v-slot:activator="{ props }">
            <v-btn icon v-bind="props" variant="text">
              <v-avatar size="38" color="brown-lighten-4">
                <v-img v-if="user?.profile_photo_url" :src="user.profile_photo_url" alt="Avatar"></v-img>
                <v-icon v-else size="large" color="brown-darken-2">mdi-account</v-icon>
              </v-avatar>
            </v-btn>
          </template>

          <v-list class="pa-2">
            <v-list-item class="mb-2">
              <template v-slot:prepend>
                <v-avatar size="40">
                  <v-img :src="user?.profile_photo_url" alt="Avatar"></v-img>
                </v-avatar>
              </template>
              <v-list-item-title class="font-weight-bold">{{ user?.name }}</v-list-item-title>
              <v-list-item-subtitle>{{ user?.email }}</v-list-item-subtitle>
            </v-list-item>

            <v-divider class="my-1"></v-divider>

            <v-list-item prepend-icon="mdi-account-outline" title="Mi perfil" to="/perfil" rounded="md" class="mb-1">
            </v-list-item>

            <v-list-item prepend-icon="mdi-logout" title="Cerrar sesión" @click="showLogoutDialog = true" rounded="md"
              color="error">
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </div>
  </v-app-bar>

  <!-- App bar para usuarios no logueados -->
  <v-app-bar v-else color="#D1D9C1" elevation="2" class="px-md-10">
    <v-img :src="logo" max-width="150" class="ml-4" />
    <v-spacer />
    <v-btn icon variant="text" to="/login">
      <v-avatar size="32">
        <v-icon size="large" color="brown-lighten-3">mdi-account-circle</v-icon>
      </v-avatar>
    </v-btn>
  </v-app-bar>
  <v-dialog v-model="showLogoutDialog" max-width="400">
    <v-card>
      <v-card-title class="text-h4" style="background-color: #D1D9C1;">
        Cerrar sesión
      </v-card-title>
      <v-card-text>
        ¿Estas seguro que quieres cerrar sesión?
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
          color="grey-darken-1"
          variant="text"
          @click="showLogoutDialog = false"
        >
          Cancelar
        </v-btn>
        <v-btn
          color="error"
          variant="elevated"
          @click="confirmLogout"
        >
          Sí, salir
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped>
.text-overline {
  letter-spacing: 0.1em !important;
  font-size: 0.6rem !important;
}

.gap-3 {
  gap: 12px;
}
</style>
