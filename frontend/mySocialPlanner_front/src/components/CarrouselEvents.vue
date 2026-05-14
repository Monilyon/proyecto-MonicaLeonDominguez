<template>
  <v-card class="mx-auto my-12 rounded-xl elevation-2" color="#d6dec1" max-width="90%" height="auto">
    <v-row no-gutters align="center" class="fill-height">
      <!-- lado izquierdo: texto y botón -->
      <v-col cols="12" md="5" class="pa-10 d-flex flex-column align-center">
        <h2 class="text-h4 font-weight-bold mb-2" style="color: #2c3e2d;">
          Próximos eventos.
        </h2>
        <p class="text-subtitle-1 mb-2 text-center" style="color: #2c3e2d;">
          Descubre los próximos eventos que tenemos para ti. Siempre hay algo emocionante por venir.
        </p>
      </v-col>

      <v-col cols="12" md="7" class="pa-6">
        <v-skeleton-loader v-if="loading" type="card" height="300" class="rounded-lg" />

        <v-alert v-else-if="error" type="error" variant="tonal" class="rounded-lg">
          {{ error }}
        </v-alert>

        <v-card v-else-if="events.length" rounded="lg" elevation="4">
          <v-carousel height="300" show-arrows="hover" hide-delimiter-background cycle interval="5000">
            <v-carousel-item v-for="event in events" :key="event.id" :src="categoria" @click="goToEvent(event.id)"
              class="cursor-pointer">
              <v-sheet class="d-flex align-end pa-6 fill-height" color="transparent"
                style="background: linear-gradient(transparent, rgba(0,0,0,0.7));">
                <div class="text-white">
                  <div class="font-weight-bold">Tipo de evento: {{ event.name }}</div>
                  <div class="text-subtitle-2">Localización: {{ event.location }}</div>
                  <div class="text-body-2">Fecha: {{ formatDate(event.date) }}</div>
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
import categoria from '@/assets/categorias.png';
import { useRouter } from 'vue-router';

const { events, loading, error } = useEvents();
const router = useRouter();

const goToEvent = (id: number) => {
  router.push({ name: 'Calendario', params: { eventId: id } });
};
const formatDate = (dateString: string) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('es-ES', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  });
};
</script>

<style scoped>
.v-carousel-item {
  transition: 1s ease-in-out;
}
.cursor-pointer {
  cursor: pointer;
}
</style>
