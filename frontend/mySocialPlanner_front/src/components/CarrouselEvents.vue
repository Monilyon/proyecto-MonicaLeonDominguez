<template>
  <v-card
    class="mx-auto my-12 rounded-xl elevation-2"
    color="#d6dec1"
    max-width="90%"
    height="auto"
  >
    <v-row no-gutters align="center" class="fill-height">
      <!-- lado izquierdo: texto y botón -->
      <v-col cols="12" md="5" class="pa-10 d-flex flex-column align-center">
        <h2 class="text-h4 font-weight-bold mb-6" style="color: #2c3e2d;">
          Próximos eventos.
        </h2>

        <v-btn
          color="#4e5b41"
          theme="dark"
          rounded="xl"
          size="large"
          class="text-none px-8"
          elevation="1"
        >
          Explorar
        </v-btn>
      </v-col>

      <v-col cols="12" md="7" class="pa-6">
        <v-skeleton-loader
          v-if="loading"
          type="card"
          height="300"
          class="rounded-lg"
        />

        <v-alert
          v-else-if="error"
          type="error"
          variant="tonal"
          class="rounded-lg"
        >
          {{ error }}
        </v-alert>

        <v-card v-else-if="events.length" rounded="lg" elevation="4">
          <v-carousel
            height="300"
            show-arrows="hover"
            hide-delimiter-background
            cycle
            interval="5000"
          >
            <v-carousel-item
              v-for="event in events"
              :key="event.id"
              width="100%"
              :src="categoria"
            >
              <v-sheet
                class="d-flex align-end pa-6 fill-height"
                color="transparent"
                style="background: linear-gradient(transparent, rgba(0,0,0,0.4));"
              >
                <div class="text-white">
                  <div class="font-weight-bold">Tipo de evento: {{ event.name }}</div>
                  <div class="text-subtitle-2">Localización: {{ event.location }}</div>
                  <div class="text-body-2">Fecha y hora: {{ event.date }}</div>
                </div>
              </v-sheet>
            </v-carousel-item>
          </v-carousel>
        </v-card>

        <v-sheet v-else class="pa-10 text-center rounded-lg" color="white">
          <v-icon size="large" color="grey">mdi-calendar-blank</v-icon>
          <p>No hay eventos disponibles por ahora.</p>
        </v-sheet>
      </v-col>
    </v-row>
  </v-card>
</template>

<script setup lang="ts">
import { useEvents } from '@/composables/useEvent';
import categoria from '@/assets/Tipos de eventos.png';
const { events, loading, error } = useEvents();
</script>

<style scoped>
.v-carousel-item {
  transition: 0.5s ease-in-out;
}
</style>
