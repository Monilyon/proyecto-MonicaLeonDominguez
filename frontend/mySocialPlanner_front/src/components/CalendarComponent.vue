<template>
  <v-app>
    <v-main class="bg-grey-lighten-5">
      <v-container fluid>
        <!-- Pantalla de carga -->
        <v-overlay :model-value="loading" class="align-center justify-center" persistent>
          <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
        </v-overlay>

        <v-row justify="center">
          <v-col cols="12" md="11">
            <v-card class="pa-4 shadow-lg" rounded="xl" elevation="2">

              <v-toolbar flat color="brown-lighten-5" rounded="xl">
                <v-btn icon="mdi-chevron-left" @click="changeMonth(-1)"></v-btn>
                <v-toolbar-title class="text-h5  text-capitalize font-weight-bold">
                  {{ formattedTitle }}
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn icon="mdi-chevron-right" @click="changeMonth(1)"></v-btn>
              </v-toolbar>

              <v-calendar
                v-model="calendarValue"
                :events="formattedEvents"
                view-mode="month"
                class="custom-calendar mt-2"
              >
                <template v-slot:event="{ event }">
                  <div
                    :class="['event-block', event.colorClass]"
                    @click.stop="openDetails(event.raw)"
                  >
                    <v-icon size="small" class="mr-1">{{ event.icon }}</v-icon>
                    <span class="event-title text-truncate">{{ event.title }}</span>
                  </div>
                </template>
              </v-calendar>
            </v-card>
          </v-col>
        </v-row>

        <v-dialog v-model="detailsDialog" max-width="500px">
          <v-card v-if="selectedEvent" rounded="xl">
            <v-toolbar
              :class="EVENT_TYPE_COLORS[selectedEvent.id_type]?.color || 'bg-grey-lighten-3'"
              flat
            >
              <v-icon class="ml-4">{{ EVENT_TYPE_COLORS[selectedEvent.id_type]?.icon }}</v-icon>
              <v-toolbar-title class="font-weight-bold">
                {{ EVENT_TYPE_COLORS[selectedEvent.id_type]?.label }}
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon="mdi-close" @click="detailsDialog = false"></v-btn>
            </v-toolbar>

            <v-card-text class="pa-6">
              <div class="text-h4 mb-4 font-weight-bold">{{ selectedEvent.name }}</div>
              <p class="text-body-1 text-grey-darken-1">{{ selectedEvent.description }}</p>

              <v-divider class="my-4"></v-divider>

              <v-list density="compact" class="bg-transparent pa-0">
                <v-list-item prepend-icon="mdi-map-marker" :title="selectedEvent.location"></v-list-item>
                <v-list-item prepend-icon="mdi-calendar-clock" :title="formatFullDate(selectedEvent.date)"></v-list-item>
                <v-list-item prepend-icon="mdi-account-group" :title="'Capacidad: ' + selectedEvent.capacity + ' personas'"></v-list-item>
              </v-list>
            </v-card-text>
            <v-btn variant="outlined" color="green-darken-1" :size="'large'" class="mb-6 mx-6" @click="console.log(`Inscribirse al evento con ID: ${selectedEvent.id}`)">
              Inscribirse
            </v-btn>
          </v-card>
        </v-dialog>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { useEvents } from '@/composables/useEvent';
import { EVENT_TYPE_COLORS } from '@/types/Event';
import type { MyEvent } from '@/types/Event';

const { events, loading } = useEvents(null);

const calendarValue = ref<Date | string>(new Date());
const detailsDialog = ref(false);
const selectedEvent = ref<MyEvent | null>(null);

const formattedEvents = computed(() => {
  return events.value.map((event: MyEvent) => {
    const id = Number(event.id_type);
    const config = EVENT_TYPE_COLORS[id];

    return {
      title: event.name,
      start: new Date(event.date),
      colorClass: config?.color || 'bg-grey-lighten-3',
      icon: config?.icon || 'mdi-help-circle',
      raw: event
    };
  });
});

const formattedTitle = computed(() => {
  return new Intl.DateTimeFormat('es-ES', { month: 'long', year: 'numeric' })
    .format(new Date(calendarValue.value));
});

const formatFullDate = (dateStr: string) => {
  return new Date(dateStr).toLocaleDateString('es-ES', {
    weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
  });
};

const changeMonth = (dir: number) => {
  const d = new Date(calendarValue.value);
  d.setMonth(d.getMonth() + dir);
  calendarValue.value = d;
};

const openDetails = (event: MyEvent) => {
  selectedEvent.value = event;
  detailsDialog.value = true;
};
</script>

<style scoped>
.custom-calendar {
  height: 650px;
}

.event-block {
  flex: 1 1 auto;
  width: 100%;
  display: flex;
  align-items: center;
  padding: 2px 8px;
  border-radius: 4px;
  cursor: pointer;
  border: 1px solid rgba(0,0,0,0.05);
  transition: filter 0.2s;
}

.event-block:hover {
  filter: brightness(0.9);
}

.event-title {
  font-size: 0.7rem;
  font-weight: 700;
  color: #2c3e50;
}
</style>
