<script setup lang="ts">
import logo from '@/assets/LogoHorizontal.png';
import { useAuth } from '@/composables/useAuth';

const { isLoggedIn, user, logout } = useAuth();
</script>

<template>
  <v-app-bar v-if="isLoggedIn" color="#D1D9C1" elevation="2">
    <v-img :src="logo" style="max-width: 100px; margin-left: 2%;" />

    <v-spacer />

    <v-btn variant="text" to="/">Inicio</v-btn>
    <v-btn variant="text" to="/calendar">Calendario</v-btn>
    <v-btn variant="text" to="/MyEvents">Mis eventos</v-btn>

    <v-spacer />

    <div class="d-flex align-center gap-3">
      <div class="text-right mr-3">
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

            <v-list-item prepend-icon="mdi-logout" title="Cerrar sesión" @click="logout" rounded="md" color="error">
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </div>
  </v-app-bar>

  <v-app-bar v-else color="#D1D9C1" elevation="2" class="px-md-10">
    <div class="d-flex flex-column align-center">
      <v-img :src="logo" width="200" />
    </div>

    <v-spacer />

    <v-btn icon variant="text" to="/login">
      <v-avatar size="32">
        <v-icon size="large" color="brown-lighten-3">mdi-account-circle</v-icon>
      </v-avatar>
    </v-btn>
  </v-app-bar>
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
