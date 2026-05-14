<template>
  <v-container class="py-10">
    <v-row>
      <v-col cols="12" md="7">
        <v-card rounded="xl" elevation="2" class="pa-6 card-border" color="#F2EAE9">
          <div class="d-flex justify-space-between">
            <v-card-title class="text-h6 font-weight-bold px-0 mb-4 title-green">
              Información del Perfil
            </v-card-title>
            <v-btn rounded class="px-0" :loading="updating" append-icon="mdi-pencil" @click="editMode = !editMode">

              <v-tooltip activator="parent" location="top">
                {{ editMode ? 'Habilitar edición' : 'Cancelar edición' }}
              </v-tooltip>
            </v-btn>
          </div>

          <v-form @submit.prevent="handleUpdate">
            <v-row align="center">
              <v-col cols="12" sm="4" class="text-center">
                <v-hover v-slot="{ isHovering, props }">
                  <v-avatar size="150" :readonly="editMode" :color="editMode ? 'grey' : '#6B7A5F'"
                    :class="{ 'field-disabled': editMode }"
                    :append-inner-icon="editMode ? 'mdi-lock-outline' : 'mdi-pencil-outline'"
                    class="elevation-2 mb-4 position-relative" v-bind="props">
                    <v-img :src="imagePreview || user?.profile_photo_url">
                      <template v-slot:placeholder>
                        <v-row class="fill-height ma-0" align="center" justify="center">
                          <v-icon size="64" color="grey">mdi-account</v-icon>
                        </v-row>
                      </template>
                    </v-img>

                    <v-fade-transition>
                      <div v-if="isHovering" class="avatar-overlay d-flex align-center justify-center"
                        @click="triggerFileInput">
                        <v-icon color="white" size="large">mdi-camera</v-icon>
                      </div>
                    </v-fade-transition>
                  </v-avatar>
                </v-hover>
                <input type="file" ref="fileInput" hidden accept="image/*" @change="onFileSelected" />
                <p class="text-caption text-grey">Haz clic en la imagen para cambiarla</p>
              </v-col>

              <v-col cols="12" sm="8">
                <div class="mb-4 text-left">
                  <label class="text-subtitle-2 font-weight-bold">Nombre</label>
                  <v-text-field :readonly="editMode" :color="editMode ? 'grey' : '#6B7A5F'"
                    :class="{ 'field-disabled': editMode }"
                    :append-inner-icon="editMode ? 'mdi-lock-outline' : 'mdi-pencil-outline'" v-model="form.name"
                    variant="underlined" density="compact" hide-details></v-text-field>
                </div>

                <div class="mb-4 text-left">
                  <label class="text-subtitle-2 font-weight-bold">Apellido</label>
                  <v-text-field :readonly="editMode" :color="editMode ? 'grey' : '#6B7A5F'"
                    :class="{ 'field-disabled': editMode }"
                    :append-inner-icon="editMode ? 'mdi-lock-outline' : 'mdi-pencil-outline'" v-model="form.last_name"
                    variant="underlined" density="compact" hide-details></v-text-field>
                </div>

                <div class="mb-4 text-left">
                  <label class="text-subtitle-2 font-weight-bold">Email</label>
                  <v-text-field :readonly="editMode" :color="editMode ? 'grey' : '#6B7A5F'"
                    :class="{ 'field-disabled': editMode }"
                    :append-inner-icon="editMode ? 'mdi-lock-outline' : 'mdi-pencil-outline'" v-model="form.email"
                    variant="underlined" density="compact" hide-details></v-text-field>
                </div>

                <div class="mb-4 text-left">
                  <label class="text-subtitle-2 font-weight-bold">Teléfono</label>
                  <v-text-field :readonly="editMode" :color="editMode ? 'grey' : '#6B7A5F'"
                    :class="{ 'field-disabled': editMode }"
                    :append-inner-icon="editMode ? 'mdi-lock-outline' : 'mdi-pencil-outline'" v-model="form.phone"
                    variant="underlined" density="compact" hide-details></v-text-field>
                </div>

                <div class="mb-2 text-left">
                  <label class="text-subtitle-2 font-weight-bold text-grey">Rol</label>
                  <v-chip class="text-body-1 text-capitalize mb-4">{{ user?.rol || 'Usuario' }}</v-chip>
                </div>
              </v-col>
            </v-row>

            <v-alert v-if="error" type="error" variant="tonal" density="compact" class="mt-4">
              {{ error }}
            </v-alert>

            <section class="text-right d-flex justify-space-between">
              <v-btn v-if="user?.rol === 'admin'" color="#6B7A5F" rounded="pill" class="text-none font-weight-bold"
                 @click="goToAdminPanel">
                Panel Administrador
              </v-btn>
              <v-btn color="#6B7A5F" rounded="pill" class="text-none font-weight-bold px-8" type="submit"
                :loading="updating">
                Guardar Cambios
              </v-btn>
            </section>
          </v-form>
        </v-card>
      </v-col>

      <MyInfoEvents />
    </v-row>

    <v-snackbar v-model="showSuccess" color="#9DB094" rounded="pill" timeout="3000">
      ¡Perfil actualizado correctamente!
    </v-snackbar>
  </v-container>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue';
import { useAuth } from '@/composables/useAuth';
import MyInfoEvents from '@/components/MyInfoEvents.vue';

const { user, updateProfile, error } = useAuth();

const updating = ref(false);
const showSuccess = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);
const imagePreview = ref<string | null>(null);
const selectedFile = ref<File | null | undefined>(null);
const editMode = ref(true);

const form = reactive({
  name: user.value?.name || '',
  last_name: user.value?.last_name || '',
  email: user.value?.email || '',
  phone: user.value?.phone || ''
});

const triggerFileInput = () => {
  fileInput.value?.click();
};

const onFileSelected = (e: Event) => {
  const target = e.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];
    selectedFile.value = file;
    imagePreview.value = URL.createObjectURL(file);
  }
};

const handleUpdate = async () => {
  updating.value = true;
  try {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('last_name', form.last_name);
    formData.append('email', form.email);
    formData.append('phone', form.phone);

    if (selectedFile.value) {
      formData.append('photo', selectedFile.value);
    }

    await updateProfile(formData);

    showSuccess.value = true;
    imagePreview.value = null;
    selectedFile.value = null;
  } catch (err: unknown) {
    console.error("Error al actualizar el perfil:", err);
  } finally {
    updating.value = false;
  }
};

// Redirección al panel de administrador
const goToAdminPanel = () => {
  window.location.href = 'http://localhost:8000/';
};
</script>

<style scoped>
.title-green {
  color: #6B7A5F;
}

.card-border {
  border: 1px solid #E0D6D4 !important;
}

.avatar-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  border-radius: 50%;
  cursor: pointer;
  transition: opacity 0.3s ease;
}
label {
  display: block;
  color: #555;
  font-size: 0.85rem;
}

.text-left {
  text-align: left !important;
}
</style>
