<template>
  <v-app>
    <!-- Fondo blanco y altura completa -->
    <v-main class="bg-white fill-height">
      <v-container fluid class="fill-height px-md-16">
        <v-row align="center" justify="center" no-gutters>

          <!-- COLUMNA IZQUIERDA: Texto estático -->
          <v-col cols="12" md="5" class="pa-4 pr-md-12">
            <h1 class="text-h2 font-weight-bold mb-6 text-green-darken-3">
              Mis Eventos
            </h1>
            <p class="text-h6 text-grey-darken-1 font-weight-regular lh-1-5">
              Aquí puedes encontrar los eventos en los cuales estás inscritos diferenciados por categoría
            </p>
          </v-col>

          <!-- COLUMNA DERECHA: Listado con Scroll -->
          <v-col cols="12" md="7" class="pa-4">

            <div
              style="max-height: 500px;"
              class="overflow-y-auto pr-4 custom-scroll"
            >

              <div v-if="!isLoggedIn">
                <v-alert type="info" variant="tonal" class="rounded-xl">
                  Inicia sesión para ver y gestionar tus inscripciones.
                </v-alert>
              </div>

              <div v-else-if="loading" class="d-flex flex-column gap-4">
                <v-skeleton-loader
                  v-for="n in 3"
                  :key="n"
                  type="list-item-avatar-three-line"
                  class="mb-4 rounded-xl"
                />
              </div>

              <v-alert
                v-else-if="registrations.length === 0"
                type="warning"
                variant="tonal"
                class="rounded-xl"
              >
                No tienes inscripciones todavía.
              </v-alert>

              <div v-else>
                <div
                  v-for="registration in registrations"
                  :key="registration.id"
                  class="mb-1"
                >
                  <MyEventsCard :registration="registration" />
                </div>
              </div>
            </div>
          </v-col>

        </v-row>
        <!-- <theFooter/> -->
        <v-snackbar v-model="snackbar" :color="snackbarColor" location="bottom">
          {{ snackbarMessage }}
        </v-snackbar>
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup lang="ts">
import { onMounted, ref, watch } from 'vue';
import { useAuth } from '@/composables/useAuth';
import { useRegistration } from '@/composables/useRegistration';
import MyEventsCard from '@/components/MyEventsCard.vue';
// import TheFooter from '@/components/TheFooter.vue';
const { isLoggedIn } = useAuth();
const { registrations, loading, error, fetchRegistrations } = useRegistration();

const snackbar = ref(false);
const snackbarMessage = ref('');
const snackbarColor = ref('success');

const showSnackbar = (message: string, color: 'success' | 'error' = 'success') => {
  snackbarMessage.value = message;
  snackbarColor.value = color;
  snackbar.value = true;
};

onMounted(async () => {
  if (isLoggedIn.value) await fetchRegistrations();
});

watch(error, (currentError) => {
  if (currentError) showSnackbar(currentError, 'error');
});
</script>

<style scoped>
.lh-1-5 {
  line-height: 1.5;
}

.text-green-darken-3 {
  color: #6d7e6e !important;
}
</style>
