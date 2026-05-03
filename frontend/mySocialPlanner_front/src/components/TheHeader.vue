<script setup lang="ts">
import logo from '@/assets/LogoHorizontal.png';
import { useAuth } from '@/composables/useAuth';

const { isLoggedIn, user, logout } = useAuth();
</script>

<template>
  <v-app-bar v-if="isLoggedIn" color="#D1D9C1" elevation="2">
    <v-img :src="logo" style="max-width: 100px; margin-left: 2%;" />

    <v-spacer />

    <v-btn variant="text" to="/">Home</v-btn>
    <v-btn variant="text" to="/calendar">Calendario</v-btn>
    <v-btn variant="text" to="/my-events">Mis eventos</v-btn>

    <v-spacer />

    <div class="d-flex align-center gap-3">
      <div class="text-right">
        <div class="text-caption">Hola, <strong>{{ user?.name || 'Usuario' }}</strong></div>
      </div>
      <div class="d-flex align-center">
        <v-menu min-width="150px" rounded="lg">
          <template v-slot:activator="{ props }">
            <v-btn icon v-bind="props" variant="text">
              <v-avatar size="36" color="brown-lighten-4">
                <v-icon size="large" color="brown-darken-2">mdi-account-circle</v-icon>
              </v-avatar>
            </v-btn>
          </template>

          <v-list class="pa-2">
            <v-list-item prepend-icon="mdi-account-outline" title="Mi perfil" to="/perfil" rounded="md" class="mb-1">
            </v-list-item>

            <v-divider class="my-1"></v-divider>

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
/*
  Si el logo necesita un ajuste de color o filtro específico
  para que coincida con el verde oliva de la imagen.png
*/
.text-overline {
  letter-spacing: 0.1em !important;
  font-size: 0.6rem !important;
}
</style>
