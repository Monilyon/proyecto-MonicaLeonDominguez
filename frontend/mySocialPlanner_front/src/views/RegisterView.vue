<template>
  <v-container fluid class="fill-height register-bg pa-0">
    <v-row no-gutters align="center" justify="center" class="fill-height">

      <v-col cols="12" md="5" class="d-flex flex-column align-center justify-center">
        <v-img :src="LogoGrande" width="300"></v-img>
        <v-btn variant="text" class="text-none permisos-link" @click="dialogPermisos = true">
          • Documentos de permisos
        </v-btn>
      </v-col>

      <v-col cols="12" md="4" class="d-flex justify-center">
        <v-card class="pa-6 register-card" elevation="4" rounded="xl" color="#F2EAE9">
          <v-card-text class="text-center">
            <h1 class="text-h4 font-weight-bold mb-4 title-green">Registro</h1>

            <v-form @submit.prevent="handleRegister">
              <v-alert v-if="error" type="error" variant="tonal" density="compact" class="mb-4 text-left">
                {{ error }}
              </v-alert>

              <div class="input-group text-left">
                <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Nombre usuario</p>
                <v-text-field v-model="form.name" variant="outlined" bg-color="white" rounded="pill" density="compact"
                  hide-details class="mb-3 custom-input"></v-text-field>

                <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Correo electrónico</p>
                <v-text-field v-model="form.email" type="email" variant="outlined" bg-color="white" rounded="pill"
                  density="compact" hide-details class="mb-3 custom-input"></v-text-field>

                <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Confirmar correo</p>
                <v-text-field v-model="form.email_confirmation" type="email" variant="outlined" bg-color="white"
                  rounded="pill" density="compact" hide-details class="mb-3 custom-input"></v-text-field>

                <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Contraseña</p>
                <v-text-field v-model="form.password" type="password" variant="outlined" bg-color="white" rounded="pill"
                  density="compact" hide-details class="mb-6 custom-input"></v-text-field>
              </div>

              <v-btn type="submit" color="#9DB094" class="text-none px-12 btn-pill font-weight-bold" rounded="pill"
                size="large" :loading="loading" block>
                Registrarme
              </v-btn>

              <v-btn variant="text" size="small" class="mt-2 text-none" to="/login">
                ¿Ya tienes cuenta? Inicia sesión
              </v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-dialog v-model="dialogPermisos" max-width="500">
      <v-card rounded="xl" class="pa-4">
        <v-card-title class="font-weight-bold">Documentos de permisos</v-card-title>
        <v-card-text>
          Aquí se detallan las normas de la comunidad y la protección de datos...
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="#6B7A5F" variant="text" @click="dialogPermisos = false">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <TheFooter />
  </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAuth } from '@/composables/useAuth'
import TheFooter from '@/components/TheFooter.vue'
import LogoGrande from '@/assets/Logo circular v4.png'

const { register, loading, error } = useAuth()
const dialogPermisos = ref(false)

const form = reactive({
  name: '',
  email: '',
  email_confirmation: '',
  password: ''
})

const handleRegister = async () => {
  await register({ ...form })
}
</script>

<style scoped>
.register-bg {
  background-color: #FAF7F6;
}

.title-green {
  color: #6B7A5F;
}

.register-card {
  width: 100%;
  max-width: 420px;
  border: 1px solid #E0D6D4 !important;
}

.custom-input :deep(.v-field__outline) {
  --v-field-border-opacity: 0.1;
}

.permisos-link {
  color: #444;
  font-size: 0.85rem;
}

.btn-pill {
  color: #2E3A23 !important;
}
</style>
