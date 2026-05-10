<template>
  <v-container fluid class="fill-height register-bg pa-0">
    <v-row no-gutters align="center" justify="center" class="fill-height">

      <v-col cols="12" md="6" class="d-flex flex-column align-center justify-center">
        <v-img :src="LogoGrande" width="300"></v-img>
        <v-btn variant="text" class="text-none permisos-link" @click="dialogPermisos = true">
          • Documentos de permisos
        </v-btn>
      </v-col>

      <v-col cols="12" md="6" class="d-flex justify-center">
        <v-card class="pd-2 my-6 register-card" elevation="4" rounded="xl" color="#F2EAE9" style="width: 80%;">
          <v-card-text class="text-center">
            <h1 class="text-h4 font-weight-bold title-green">Registro</h1>

            <v-form @submit.prevent="handleRegister">
              <v-alert v-if="error" type="error" variant="tonal" density="compact" class="mb-4 text-left">
                {{ error }}
              </v-alert>

              <div class="input-group text-left">
                <div class="d-flex gap-3 mb-3">
                  <div class="flex-grow-1">
                    <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Nombre</p>
                    <v-text-field v-model="form.name" variant="outlined" bg-color="white" rounded="pill"
                      density="compact" hide-details class="custom-input"></v-text-field>
                  </div>

                  <div class="flex-grow-1">
                    <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Apellido</p>
                    <v-text-field v-model="form.last_name" variant="outlined" bg-color="white" rounded="pill"
                      density="compact" hide-details class="custom-input"></v-text-field>
                  </div>
                </div>
                <div class="d-flex gap-3 mb-6">
                  <div class="flex-grow-1">
                    <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Teléfono</p>
                    <v-text-field v-model="form.phone" variant="outlined" bg-color="white" rounded="pill"
                      density="compact" hide-details class="custom-input"></v-text-field>
                  </div>

                  <div class="flex-grow-1">
                    <p class="text-subtitle-2 font-weight-bold mb-1 ml-4">Foto de perfil</p>
                    <v-file-input @change="onFileSelected" variant="outlined" bg-color="white" rounded="pill"
                      density="compact" prepend-inner-icon="mdi-camera" class="custom-input" prepend-icon=""
                      accept="image/*"></v-file-input>
                  </div>
                </div>

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
          <div>
            <h3 class="text-h6 font-weight-bold">Compromiso de Asistencia</h3>
              <p class="text-body-2 mb-0" >
                <strong>Recuerda:</strong> Las plazas son limitadas. Solo podrás asistir si tu estado es
                <strong>"Admitido"</strong>. Te comprometes a avisar si no puedes venir para liberar tu
                plaza.
              </p>
          </div>
          <div>
            <h3 class="text-h6 font-weight-bold">Permisos de Imagen</h3>
            <p class="text-body-2 text-grey-darken-2">
              Durante el evento se realizarán fotos y videos para nuestras redes sociales.
              <br><strong>Recuerda</strong> al realizar la inscripción, aceptar o declinar el permiso de imagen. Si aceptas, autorizas el uso de tu imagen para promocionar futuros eventos. Si no deseas que se use tu imagen, por favor declina el permiso y avísanos en caso de ser seleccionado para asistir.
            </p>
          </div>

        </v-card-text>

        <v-card-actions>

          <v-spacer></v-spacer>

          <v-btn color="#6B7A5F" variant="text" @click="dialogPermisos = false">Cerrar</v-btn>

        </v-card-actions>

      </v-card>

    </v-dialog>
  </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useAuth } from '@/composables/useAuth'
import LogoGrande from '@/assets/Logo circular v4.png'

const { register, loading, error } = useAuth()
const dialogPermisos = ref(false)
const selectedFile = ref<File | null | undefined>(null)

const form = reactive({
  name: '',
  last_name: '',
  phone: '',
  email: '',
  email_confirmation: '',
  password: ''
})

const onFileSelected = (e: Event) => {
  const files = (e.target as HTMLInputElement).files;
  if (files) {
    selectedFile.value = files[0];
  }
}

const handleRegister = async () => {
  const formData = new FormData()
  formData.append('name', form.name)
  formData.append('last_name', form.last_name)
  formData.append('phone', form.phone)
  formData.append('email', form.email)
  formData.append('email_confirmation', form.email_confirmation)
  formData.append('password', form.password)

  if (selectedFile.value) {
    formData.append('photo', selectedFile.value)
  }
  await register(formData)
}
</script>
