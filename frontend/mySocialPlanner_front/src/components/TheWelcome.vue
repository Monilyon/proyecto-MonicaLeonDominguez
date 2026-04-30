<script setup lang="ts">
import photo1 from '@/assets/grupo.png';

</script>

<template>
  <v-img :src="photo1" height="90vh" cover width="100%" class="align-center shadow-hero">
    <div class="absolute-fill gradient-overlay"></div>

    <v-container class="relative-content">
      <v-row justify="end" align="center">
        <v-col cols="12" md="6" lg="5" class="text-right white--text">
          <h1 class="font-weight-bold mb-4 main-title">
            My social planner
          </h1>
          <p class="text-h5 font-weight-medium mb-6 subtitle">
            Descubre experiencias únicas, participa en la comunidad y transforma cada momento en algo memorable.
          </p>
        </v-col>
      </v-row>
    </v-container>
  </v-img>
</template>

<style scoped>
:host {
  display: block;
  width: 100%;
}
.main-title {
  color: #5a735f;
  font-weight: bolder;
  text-shadow: 1px 1px 2px rgba(255,255,255,0.5);
}
.subtitle {
  color: #333;
  line-height: 1.4;
}
.gradient-overlay {
background: linear-gradient(to right, rgba(255,255,255,0) 20%, rgba(255,255,255,0.4) 100%);
  position: absolute;
  inset: 0;
}

.relative-content {
  position: relative;
  z-index: 1;
}

</style>
