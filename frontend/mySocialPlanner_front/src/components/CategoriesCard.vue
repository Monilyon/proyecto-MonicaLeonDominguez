<template>
  <v-container>
    <v-row>
      <v-col
        v-for="(item, index) in categories"
        :key="index"
        cols="12" sm="6" md="6"
        style="height: 250px;"
      >
        <!-- Eliminamos @click y la clase dinámica :class -->
        <div class="flip-card">
          <div class="flip-card-inner">

            <!-- PARTE FRONTAL -->
            <v-card class="flip-card-front" elevation="4">
              <v-row no-gutters class="fill-height">
                <v-col cols="7">
                  <v-img :src="item.image" cover height="100%"></v-img>
                </v-col>
                <v-col
                  cols="5"
                  :class="item.color"
                  class="d-flex align-center justify-center"
                >
                  <span class="text-h6 font-weight-bold text-center">
                    {{ item.title }}
                  </span>
                </v-col>
              </v-row>
            </v-card>

            <!-- PARTE TRASERA -->
            <v-card
              class="flip-card-back d-flex align-center justify-center pa-4"
              :color="item.color"
              elevation="4"
            >
              <div class="text-center">
                <h3 class="mb-2">{{ item.title }}</h3>
                <p>{{ item.description }}</p>
              </div>
            </v-card>

          </div>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const categories = ref([
  {
    title: 'Deportes',
    image: new URL('@/assets/Deporte Acuarela.png', import.meta.url).href,
    color: 'green-lighten-4',
    description: 'Actividades físicas para mantenerte en forma y competir sanamente.'
  },
  {
    title: 'Cultura',
    image: new URL('@/assets/Cultura Acuarela.png', import.meta.url).href,
    color: 'amber-lighten-4',
    description: 'Explora museos, arte, historia y tradiciones locales.'
  },
  {
    title: 'Ocio',
    image: new URL('@/assets/Ocio Acuarela.png', import.meta.url).href,
    color: 'pink-lighten-4',
    description: 'Momentos de relax, campamentos y diversión al aire libre.'
  },
  {
    title: 'Acción Social',
    image: new URL('@/assets/Acción Social Acuarela.png', import.meta.url).href,
    color: 'light-blue-lighten-4',
    description: 'Proyectos de voluntariado y ayuda a la comunidad.'
  }
])
</script>

<style scoped>
.flip-card {
  background-color: transparent;
  height: 250px;
  perspective: 1000px;
  cursor: pointer;
}

.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.6s;
  transform-style: preserve-3d;
}

.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  border-radius: 8px;
  overflow: hidden;
}

.flip-card-back {
  transform: rotateY(180deg);
}
</style>
