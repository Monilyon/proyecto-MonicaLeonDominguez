<template>
  <v-container fluid class="fill-height login-bg">
    <v-row align="center" justify="center">

      <v-col cols="12" md="5" class="d-flex justify-center">
        <v-img
          :src="LogoGrande"
          max-width="400px"
          contain
        ></v-img>
      </v-col>

      <v-col cols="12" md="4" class="d-flex justify-center">
        <v-card
          class="my-5 login-card"
          elevation="2"
          rounded="xl"
          color="#F2EAE9"
        >
          <v-card-text class="text-center">
            <h1 class="text-h4 font-weight-bold mb-6 title-green">
              Bienvenid@ <br> de nuevo
            </h1>

            <!-- Formulario con prevent para evitar recarga de página -->
            <v-form v-model="isFormValid" @submit.prevent="handleLogin">

              <!-- Alerta para mostrar errores del backend -->
              <v-alert
                v-if="error"
                type="error"
                variant="tonal"
                density="compact"
                class="mb-4 text-left"
                rounded="lg"
              >
                {{ error }}
              </v-alert>

              <h2 class="text-subtitle-1 font-weight-bold mb-1 text-center">Email</h2>
              <v-text-field
                v-model="email"
                variant="outlined"
                bg-color="white"
                rounded="pill"
                density="compact"
                hide-details
                :disabled="loading"
                class="mb-4 custom-input"
                placeholder="ejemplo@correo.com"
              ></v-text-field>

              <h2 class="text-subtitle-1 font-weight-bold mb-1 text-center">Contraseña</h2>
              <v-text-field
                v-model="password"
                type="password"
                variant="outlined"
                bg-color="white"
                rounded="pill"
                density="compact"
                hide-details
                :disabled="loading"
                class="mb-6 custom-input"
              ></v-text-field>

              <!-- Botón con estado de carga -->
              <v-btn
                type="submit"
                color="#9DB094"
                class="text-none px-10 mb-4 btn-pill font-weight-bold"
                rounded="pill"
                elevation="0"
                :loading="loading"
                :disabled="!email || !password"
              >
                Iniciar sesión
              </v-btn>

              <p class="text-body-2 mb-2">* No tengo cuenta</p>

              <v-btn
                variant="flat"
                color="#9DB094"
                class="text-none px-10 btn-pill font-weight-bold"
                rounded="pill"
                :disabled="loading"
                to="/register"
              >
                Registrarme
              </v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <TheFooter />
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useAuth } from '@/composables/useAuth'
import TheFooter from '@/components/TheFooter.vue'
import LogoGrande from '@/assets/Logo circular v4.png'

const { login, loading, error } = useAuth()

const email = ref('')
const password = ref('')
const isFormValid = ref(false)

const handleLogin = async () => {
  if (email.value && password.value) {
    await login({
      email: email.value,
      password: password.value
    })
  }
}

</script>

<style scoped>
.login-bg {
  background-color: #FAF7F6;
}

.title-green {
  color: #6B7A5F;
  line-height: 1.2;
}

.login-card {
  width: 100%;
  max-width: 400px;
  border: 1px solid #E0D6D4 !important;
}

.custom-input :deep(.v-field__outline) {
  --v-field-border-opacity: 0.2;
}

.btn-pill {
  border: 1px solid rgba(0,0,0,0.1);
  color: #2E3A23 !important;
}

.v-btn {
  text-transform: none !important;
  letter-spacing: normal;
}
</style>
