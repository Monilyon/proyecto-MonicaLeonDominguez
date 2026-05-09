<template>
  <v-app>
    <v-main class="bg-grey-lighten-5">
      <v-container fluid>

        <v-overlay :model-value="loading" class="align-center justify-center" persistent>
          <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
        </v-overlay>

        <v-row justify="center">
          <v-col cols="12" md="11">
            <v-card class="pa-4 shadow-lg" rounded="xl" elevation="2" style="background-color: #d1d9c1;">

              <v-toolbar flat color="brown-lighten-5" rounded="xl">
                <v-btn icon="mdi-chevron-left" @click="changeMonth(-1)"></v-btn>
                <v-toolbar-title class="text-h5  text-capitalize font-weight-bold">
                  {{ formattedTitle }}
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-select v-model="selectedCategory" :items="categoryOptions" label="Filtrar por categoría"
                  variant="solo-filled" density="compact" hide-details class="mx-4 custom" style="max-width: 250px;"
                  clearable></v-select>
                <v-btn icon="mdi-chevron-right" @click="changeMonth(1)"></v-btn>
              </v-toolbar>

              <v-calendar v-model="calendarValue" :events="formattedEvents" view-mode="month"
                class="custom-calendar mt-2">
                <template v-slot:event="{ event }">
                  <div :class="['event-block', event.colorClass]" @click.stop="openDetails(event.raw)">
                    <v-icon size="small" class="mr-1">{{ event.icon }}</v-icon>
                    <span class="event-title text-truncate">{{ event.title }}</span>
                  </div>
                </template>
              </v-calendar>
            </v-card>
          </v-col>
        </v-row>

        <v-dialog v-model="detailsDialog" max-width="520px">
          <v-card v-if="selectedEvent" rounded="xl">
            <v-toolbar :class="EVENT_TYPE_COLORS[selectedEvent.id_type]?.color || 'bg-grey-lighten-3'" flat>
              <v-icon class="ml-4">{{ EVENT_TYPE_COLORS[selectedEvent.id_type]?.icon }}</v-icon>
              <v-toolbar-title class="font-weight-bold">
                {{ EVENT_TYPE_COLORS[selectedEvent.id_type]?.label }}
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon="mdi-close" @click="closeDialog"></v-btn>
            </v-toolbar>

            <v-card-text class="pa-6">
              <div class="text-h4 mb-4 font-weight-bold">{{ selectedEvent.name }}</div>
              <p class="text-body-1 text-grey-darken-1">{{ selectedEvent.description }}</p>

              <v-divider class="my-4"></v-divider>

              <v-list density="compact" class="bg-transparent pa-0">
                <v-list-item prepend-icon="mdi-map-marker" :title="selectedEvent.location"></v-list-item>
                <v-list-item prepend-icon="mdi-calendar-clock"
                  :title="formatFullDate(selectedEvent.date)"></v-list-item>
                <v-list-item prepend-icon="mdi-account-group"
                  :title="'Capacidad: ' + selectedEvent.capacity + ' personas'"></v-list-item>
              </v-list>

              <v-row class="mt-4">
                <v-col cols="12">
                  <v-btn color="primary" block @click="showInterestForm" v-if="!formVisible">
                    Estoy interesado
                  </v-btn>
                </v-col>
              </v-row>

              <div v-if="formVisible" class="mt-4">
                <v-form>
                  <v-row>
                    <v-col cols="12" sm="6">
                      <v-text-field label="Nombre" :model-value="user?.name || ''" readonly outlined />
                    </v-col>
                    <v-col cols="12" sm="6">
                      <v-text-field label="Email" :model-value="user?.email || ''" readonly outlined />
                    </v-col>
                    <v-btn color="primary" @click="dialogConfirm = true">
                      Inscribirme al evento
                    </v-btn>

                    <v-dialog v-model="dialogConfirm" max-width="550px" persistent>
                      <v-card rounded="xl" elevation="10">
                        <v-toolbar color="primary" flat>
                          <v-icon start class="ml-4">mdi-file-check</v-icon>
                          <v-toolbar-title class="font-weight-bold">Confirmación Final</v-toolbar-title>
                          <v-spacer></v-spacer>
                          <v-btn icon="mdi-close" variant="text" @click="dialogConfirm = false"></v-btn>
                        </v-toolbar>

                        <v-card-text class="pa-6">
                          <!-- SECCIÓN 1: PERMISOS DE IMAGEN -->
                          <div class="mb-6">
                            <div class="d-flex align-center mb-2">
                              <v-icon color="primary" class="mr-2">mdi-camera-account</v-icon>
                              <h3 class="text-h6 font-weight-bold">Permisos de Imagen</h3>
                            </div>
                            <p class="text-body-2 text-grey-darken-2">
                              Durante el evento se realizarán fotos y videos para nuestras redes sociales.
                              ¿Nos das tu permiso para publicarlos sin ningún fin comercial?
                            </p>
                            <v-radio-group inline hide-details class="mt-2">
                              <v-radio label="Sí, acepto" value="yes" color="success" class="mr-6"></v-radio>
                              <v-radio label="No, prefiero que no" value="no" color="error"></v-radio>
                            </v-radio-group>
                          </div>

                          <v-divider class="mb-6"></v-divider>

                          <div>
                            <div class="d-flex align-center mb-2">
                              <v-icon color="primary" class="mr-2">mdi-alert-circle-outline</v-icon>
                              <h3 class="text-h6 font-weight-bold">Compromiso de Asistencia</h3>
                            </div>
                            <div class="bg-blue-lighten-5 pa-4 rounded-lg mb-4">
                              <p class="text-body-2 mb-0" style="color: #0d47a1;">
                                <strong>Recuerda:</strong> Las plazas son limitadas. Solo podrás asistir si tu estado es
                                <strong>"Admitido"</strong>. Te comprometes a avisar si no puedes venir para liberar tu
                                plaza.
                              </p>
                            </div>
                            <v-checkbox label="Entiendo las condiciones de asistencia y plazas limitadas."
                              color="primary" hide-details density="comfortable"></v-checkbox>
                          </div>
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions class="pa-4 bg-grey-lighten-4">
                          <v-spacer></v-spacer>
                          <v-btn text="Cancelar"  @click="closeDialog" variant="plain" color="grey-darken-1"></v-btn>
                          <v-card-actions class="justify-end pa-6" v-if="formVisible">
                            <v-btn color="green-darken-1" :loading="registerLoading" :disabled="registerLoading"
                            @click="registerForSelectedEvent">
                            Inscribirse
                          </v-btn>
                        </v-card-actions>
                      </v-card-actions>
                      </v-card>
                    </v-dialog>
                  </v-row>
                </v-form>
              </div>
            </v-card-text>


          </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" :color="snackbarColor" timeout="3500" location="bottom">
          {{ snackbarMessage }}
        </v-snackbar>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import { useEvents } from '@/composables/useEvent';
import { useAuth } from '@/composables/useAuth';
import { useRegistration } from '@/composables/useRegistration';
import { EVENT_TYPE_COLORS } from '@/types/Event';
import type { MyEvent } from '@/types/Event';
import { useRoute } from 'vue-router';

const { events, loading } = useEvents(null);
const { user } = useAuth();
const { registerEvent } = useRegistration();
const route = useRoute();
const selectedCategory = ref<number | null>(null);
const calendarValue = ref<Date | string>(new Date());
const detailsDialog = ref(false);
const selectedEvent = ref<MyEvent | null>(null);
const formVisible = ref(false);
const registerLoading = ref(false);
const snackbar = ref(false);
const snackbarMessage = ref('');
const snackbarColor = ref('success');
const dialogConfirm = ref(false);

const categoryOptions = computed(() => {
  return Object.entries(EVENT_TYPE_COLORS).map(([id, config]) => ({
    title: config.label,
    value: Number(id)
  }));
})

const formattedEvents = computed(() => {
  const filtered = events.value.filter((event: MyEvent) => {
    if (!selectedCategory.value) return true;
    return Number(event.id_type) === selectedCategory.value;
  }); return filtered.map((event: MyEvent) => {
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

const showSnackbar = (message: string, color: 'success' | 'error') => {
  snackbarMessage.value = message;
  snackbarColor.value = color === 'success' ? 'success' : 'error';
  snackbar.value = true;
};

const openDetails = (event: MyEvent) => {
  selectedEvent.value = event;
  formVisible.value = false;
  detailsDialog.value = true;
};

const closeDialog = () => {
  detailsDialog.value = false;
  formVisible.value = false;
};

const showInterestForm = () => {
  if (!user.value) {
    showSnackbar('Debes iniciar sesión para mostrar el formulario.', 'error');
    return;
  }

  formVisible.value = true;
};

const registerForSelectedEvent = async () => {
  if (!selectedEvent.value) {
    return;
  }

  if (!user.value) {
    showSnackbar('Debes iniciar sesión para inscribirte en este evento.', 'error');
    return;
  }

  registerLoading.value = true;

  try {
    await registerEvent(selectedEvent.value.id);
    showSnackbar('Inscripción enviada correctamente. Revisa Mis eventos.', 'success');
    detailsDialog.value = false;
  } catch (err: unknown) {
    const message = err instanceof Error ? err.message : 'Error al inscribirse en el evento';
    showSnackbar(message, 'error');
  } finally {
    registerLoading.value = false;
  }
};
const checkUrlParams = () => {
  const eventIdFromUrl = route.params.eventId;

  if (eventIdFromUrl && events.value.length > 0) {
    const eventToOpen = events.value.find(e => e.id === Number(eventIdFromUrl));

    if (eventToOpen) {
      openDetails(eventToOpen);

      calendarValue.value = new Date(eventToOpen.date);
    }
  }
};
watch(loading, (newLoading) => {
  if (!newLoading) {
    checkUrlParams();
  }
});
onMounted(() => {
  if (!loading.value) {
    checkUrlParams();
  }
});
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
  border: 1px solid rgba(0, 0, 0, 0.05);
  transition: filter 0.2s;
}

.event-block:hover {
  filter: brightness(0.9);
}

.custom {
  box-shadow: 2px 2px 10px rgba(185, 235, 59, 0.7);
  border-radius: 8px;
}

.event-title {
  font-size: 0.7rem;
  font-weight: 700;
  color: #2c3e50;
}
</style>
