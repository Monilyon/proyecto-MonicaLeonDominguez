<template>
  <v-footer  style="background-color: #FFF8F8;">
    <v-container>
      <v-row justify="space-between">

        <v-col cols="12" md="6">
          <div class="d-flex flex-column align-start">
            <v-img
              :src="logoHorizontal"
              width="200px"
              contain
            ></v-img>

            <ul class="custom-list">
              <li @click="dialogNormas = true">
                Normas de la comunidad
              </li>
            </ul>
          </div>
        </v-col>

        <v-col cols="12" md="4" class="d-flex flex-column align-start justify-center">
          <p class="font-weight-bold mb-2 text-subtitle-1">Podeis seguirnos en:</p>

          <div class="d-flex align-center mb-1 social-link">
            <v-icon color="pink-accent-3" class="mr-2">mdi-instagram</v-icon>
            <span>Instagram</span>
          </div>

          <div class="d-flex align-center social-link">
            <v-icon color="blue-darken-2" class="mr-2">mdi-facebook</v-icon>
            <span>Facebook</span>
          </div>
        </v-col>
      </v-row>
    </v-container>

    <v-dialog v-model="dialogNormas" max-width="600px" scrollable>
      <v-card rounded="lg">
        <v-card-title class="d-flex align-center pa-4">
          <span class="text-h5 font-weight-bold">Normas de la Comunidad</span>
          <v-spacer></v-spacer>
          <v-btn icon="mdi-close" variant="text" @click="dialogNormas = false"></v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text class="pa-6">
          <div v-for="(norma, i) in normas" :key="i" class="mb-4">
            <p class="text-body-1"><strong>{{ i + 1 }}. {{ norma.titulo }}:</strong> {{ norma.descripcion }}</p>
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-footer>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import logoHorizontal from '@/assets/LogoHorizontal.png'
const dialogNormas = ref(false)

const normas = ref([
  { titulo: 'Respeto', descripcion: 'Total respeto hacia todos los miembros de la comunidad.' },
  { titulo: 'Seguridad', descripcion: 'No se tolerará ningún comportamiento que ponga en peligro la seguridad de los miembros.' },
  { titulo: 'Cancelación', descripcion: 'Si no puedes asistir a un evento, avisa con antelación para respetar el tiempo de los demás.' },
  { titulo: 'Acoso', descripcion: 'No se permite el acoso, la discriminación o cualquier forma de violencia.' },
  { titulo: 'Colaboración', descripcion: 'Fomenta la colaboración y el apoyo mutuo entre los miembros.' },
  { titulo: 'Responsabilidad', descripcion: 'Cada miembro es responsable de sus acciones y su impacto en la comunidad.' },
  { titulo: 'Comunicación', descripcion: 'Mantén una comunicación clara y respetuosa en todas las interacciones.' },
])
</script>

<style scoped>
.custom-list {
  list-style-type: disc;
  padding-left: 20px;
  margin: 0;
}

.custom-list li {
  cursor: pointer;
  font-size: 1rem;
  color: #333;
  transition: color 0.2s;
}

.custom-list li:hover {
  color: #666;
  text-decoration: underline;
}

.social-link {
  cursor: pointer;
  font-size: 1rem;
}

.social-link:hover {
  opacity: 0.8;
}
</style>
