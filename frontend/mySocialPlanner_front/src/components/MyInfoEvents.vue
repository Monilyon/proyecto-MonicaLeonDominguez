<template>
  <v-col cols="12" md="5">
    <v-card rounded="xl" elevation="2" class="pa-6 card-border fill-height" color="#F2EAE9">
      <v-card-title class="text-h6 font-weight-bold px-0 mb-4 title-green">
        Resumen de Actividad
      </v-card-title>

      <v-list lines="two" class="bg-transparent">
        <!-- Inscripciones Activas -->
        <v-list-item class="px-0">
          <template v-slot:prepend>
            <v-avatar color="#D1D9C1" size="48" class="mr-4">
              <v-icon color="#5A6B4E">mdi-clipboard-check-outline</v-icon>
            </v-avatar>
          </template>
          <v-list-item-title class="text-subtitle-2 font-weight-bold text-left">
            Inscripciones Activas:
          </v-list-item-title>
          <v-list-item-subtitle class="text-h6 text-left">
            <v-progress-circular v-if="loadingEvents" indeterminate size="18" width="2"
              color="#6B7A5F"></v-progress-circular>
            <span v-else>{{ activeRegistrationsCount }}</span>
          </v-list-item-subtitle>
        </v-list-item>

        <!-- Próximo Evento -->
        <v-list-item class="px-0">
          <template v-slot:prepend>
            <v-avatar color="#F9E6C3" size="48" class="mr-4">
              <v-icon color="#B8860B">mdi-calendar-month</v-icon>
            </v-avatar>
          </template>
          <v-list-item-title class="text-subtitle-2 font-weight-bold text-left">
            Próximo Evento:
          </v-list-item-title>
          <v-list-item-subtitle class="text-left">
            <span v-if="loadingEvents" class="text-caption text-grey">Cargando...</span>
            <span v-else>{{ nextEvent }}</span>
          </v-list-item-subtitle>
        </v-list-item>

        <!-- Categoría Favorita -->
        <v-list-item class="px-0">
          <template v-slot:prepend>
            <v-avatar color="#F3E5F5" size="48" class="mr-4">
              <v-icon color="#7B1FA2">mdi-star-outline</v-icon>
            </v-avatar>
          </template>
          <v-list-item-title class="text-subtitle-2 font-weight-bold text-left">
            Categoría Favorita:
          </v-list-item-title>
          <v-list-item-subtitle class="text-left text-capitalize" >
            <span v-if="loadingEvents" class="text-caption text-grey">Calculando...</span>
            <span v-else>{{ favoriteCategory }}</span>
          </v-list-item-subtitle>
        </v-list-item>
      </v-list>
    </v-card>
  </v-col>
</template>

<script setup lang="ts">
import { computed, onMounted } from 'vue';
import { useRegistration } from '@/composables/useRegistration';
import type { MyRegistration } from '@/types/Registration';
import { EVENT_TYPE_COLORS } from '@/types/Event';

const { registrations, fetchRegistrations, loading: loadingEvents } = useRegistration();

onMounted(() => {
  fetchRegistrations();
});

const activeRegistrationsCount = computed(() => {
  return registrations.value.filter((r: MyRegistration) =>
    !r.status.name.toLowerCase().includes('rechazada')
  ).length;
});
const nextEvent = computed(() => {
  if (!registrations.value || registrations.value.length === 0) {
    return 'No hay eventos próximos';
  }

  // Obtenemos el inicio del día de hoy (00:00:00) para comparar justamente
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const futureEvents = registrations.value
    .filter((r: MyRegistration) => {
      // 1. Debe estar aprobada
      const isApproved = r.status?.name?.toLowerCase().includes('aprobada');
      // 2. Debe tener evento y fecha
      if (!isApproved || !r.event?.date) return false;

      const eventDate = new Date(r.event.date);
      return eventDate >= today;
    })
    .sort((a: MyRegistration, b: MyRegistration) => {
      const dateA = new Date(a.event.date).getTime();
      const dateB = new Date(b.event.date).getTime();
      return dateA - dateB;
    });if (futureEvents.length === 0) return 'No hay eventos próximos';

  const next = futureEvents[0]?.event;

  if (!next || !next.date) {
    return 'No hay eventos próximos';
  }

  const formattedDate = new Date(next.date).toLocaleDateString('es-ES', {
    day: '2-digit',
    month: '2-digit',
  });

  return `${next.name} - ${formattedDate}`;
});
const favoriteCategory = computed(() => {
  if (registrations.value.length === 0) return 'Ninguna';

  const counts: Record<number, number> = {};
  registrations.value.forEach(r => {
    const id = r.event.id_type;
    counts[id] = (counts[id] || 0) + 1;
  });

  const keys = Object.keys(counts);
  if (keys.length === 0) return 'Ninguna';

  const favoriteId = keys.reduce((a, b) =>
    (counts[Number(a)] ?? 0) > (counts[Number(b)] ?? 0) ? a : b
  );
  const categoryId = Number(favoriteId);
  const categoryConfig = EVENT_TYPE_COLORS[categoryId as keyof typeof EVENT_TYPE_COLORS];

  return categoryConfig?.label || 'Varios';
});
</script>

<style scoped></style>
