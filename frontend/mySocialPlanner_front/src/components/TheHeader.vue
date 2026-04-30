<script setup lang="ts">
import logo from '@/assets/LogoHorizontal.png';
</script>
<template>

  <!-- Aqui implementar if/else para en el caso de que el usuario esté logueado mostrar el avatar a la derecha, logo a la izquierda y
  en el centro 3 botones (home, Calendario, mis eventos) y en el caso de que no esté logueado mostrar solo el logo en el centro y
  a la derecha un botón de usuario que al hacer click redirija a iniciar sesión o registrarse -->
  <v-app-bar v-if="false" color="#D1D9C1" elevation="2" class="px-md-10">
    <v-btn variant="text">Home</v-btn>
    <v-btn variant="text">Calendario</v-btn>
    <v-btn variant="text">Mis Eventos</v-btn>

    <v-spacer />

    <div class="d-flex flex-column align-center">
      <v-img :src="logo" width="200" />
    </div>

    <v-spacer />

    <v-btn icon variant="text">
      <v-avatar size="32">
        <v-icon size="large" color="brown-lighten-3">mdi-account-circle</v-icon>
      </v-avatar>
    </v-btn>

  </v-app-bar>

  <v-app-bar v-else color="#D1D9C1" elevation="2" class="px-md-10">

    <div class="d-flex flex-column align-center">
      <v-img :src="logo" width="200" />
    </div>

    <v-spacer />

    <v-btn icon variant="text" @click="$router.push('/login')">
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
