<template>
  <v-snackbar
    v-model="showBanner"
    :timeout="-1"
    elevation="24"
    location="bottom"
    class="ma-0"
    width="100%"
  >
    <div class="d-flex flex-column align-center w-100 py-2">

      <h2 class="text-subtitle-1 my-0 font-weight-bold text-center text-white">
        🍪 Información sobre la Política de Cookies
      </h2>

      <p class="text-body-2 text-center text-white px-10">
        En cumplimiento con la normativa vigente, le informamos que este sitio web utiliza cookies técnicas, de
        personalización y analíticas. Sus datos personales no se cederán a terceros salvo obligación legal. Puede aceptar
        todas las cookies pulsando el botón "Aceptar" o Rechazarlas.
      </p>

      <div class="d-flex justify-center mt-4 w-100">
        <v-btn color="primary" variant="elevated" @click="acceptCookies" class="text-none mx-2">
          <strong>Aceptar</strong>
        </v-btn>
        <v-btn color="black" variant="elevated" @click="showBanner = false" class="mx-2">
          <strong style="color: white;">Rechazar</strong>
        </v-btn>
      </div>
    </div>

    <template v-slot:actions></template>
  </v-snackbar>
</template>

<script setup lang="ts">

import { ref, onMounted } from 'vue'

const showBanner = ref(false)

onMounted(() => {
  const cookieData = localStorage.getItem('cookie_consent')

  if (!cookieData) {
    showBanner.value = true
  } else {
    const data = JSON.parse(cookieData)
    const hoy = new Date().getTime()
    const diferencia = hoy - data.fecha
    const unDiaEnMs = 1000 * 60 * 60 * 24

    if (diferencia > unDiaEnMs) {
      localStorage.removeItem('cookie_consent')
      showBanner.value = true
    }
  }
})

const acceptCookies = () => {
  const dataToSave = {
    consent: true,
    fecha: new Date().getTime()
  }
  localStorage.setItem('cookie_consent', JSON.stringify(dataToSave))
  showBanner.value = false
}
</script><style scoped>
:deep(.v-snackbar__wrapper) {
  max-width: 100% !important;
  min-width: 100% !important;
  margin: 0 !important;
  border-radius: 0 !important;
  bottom: 0 !important;
}

:deep(.v-snackbar__content) {
  width: 100% !important;
  padding: 16px !important;
}

:deep(.v-snackbar__actions) {
  display: none !important;
}
</style>
