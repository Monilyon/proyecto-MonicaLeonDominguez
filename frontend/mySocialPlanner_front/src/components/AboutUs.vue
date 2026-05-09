<template>
  <section style="background-color: #efebe9;" class="my-4 py-4">
    <v-container>

      <v-row
        align="center"
      >

        <v-col
          cols="12"
          md="5"
          class="text-center text-md-left"
        >

          <h2 class="text-h4 font-weight-bold mb-4">
            Acerca de Nosotros
          </h2>

          <v-divider
            thickness="3"
            color="green"
            class="w-25"
          />

          <p class="text-body-1 mb-4">
            <strong>My Social Planner</strong> conecta personas mediante
            actividades y eventos sociales adaptados a sus intereses.
          </p>

          <p class="text-body-1">
            Organiza, descubre y participa en eventos de forma sencilla
            dentro de una comunidad activa y dinámica.
          </p>

        </v-col>

        <v-col
          cols="12"
          md="7"
        >

          <div class="rounded-xl overflow-hidden elevation-4">
            <v-img
              :src="community"
              cover
              height="350"
            />
          </div>

        </v-col>

      </v-row>

      <div>

        <div class="d-flex align-center justify-center ga-2">

          <v-divider
            thickness="2"
            color="black"
            class="w-25"
          />

          <h3 class="text-h5 font-weight-bolder text-black w-100 d-flex justify-center my-8" >
            Características principales
          </h3>

          <v-divider
            thickness="2"
            color="black  "
            class="w-25"
          />

        </div>

        <v-row>

          <v-col
            cols="12"
            sm="6"
            md="3"
          >
            <v-card
              rounded="xl"
              elevation="2"
              class="pa-6 text-center fill-height"
            >

              <v-avatar
                size="70"
                color="green-lighten-5"
                class="mb-4"
              >
                <v-icon
                  size="34"
                  color="green-darken-2"
                >
                  mdi-calendar
                </v-icon>
              </v-avatar>

              <h4 class="text-subtitle-1 font-weight-bold mb-3">
                Eventos personalizados
              </h4>

              <p class="text-body-2">
                Crea actividades adaptadas a tus intereses.
              </p>

            </v-card>
          </v-col>

          <v-col
            cols="12"
            sm="6"
            md="3"
          >
            <v-card
              rounded="xl"
              elevation="2"
              class="pa-6 text-center fill-height"
            >

              <v-avatar
                size="70"
                color="green-lighten-5"
                class="mb-4"
              >
                <v-icon
                  size="34"
                  color="green-darken-2"
                >
                  mdi-account-group
                </v-icon>
              </v-avatar>

              <h4 class="text-subtitle-1 font-weight-bold mb-3">
                Personas afines
              </h4>

              <p class="text-body-2">
                Conoce gente con gustos e intereses similares.
              </p>

            </v-card>
          </v-col>

          <v-col
            cols="12"
            sm="6"
            md="3"
          >
            <v-card
              rounded="xl"
              elevation="2"
              class="pa-6 text-center fill-height"
            >

              <v-avatar
                size="70"
                color="green-lighten-5"
                class="mb-4"
              >
                <v-icon
                  size="34"
                  color="green-darken-2"
                >
                  mdi-check-decagram-outline
                </v-icon>
              </v-avatar>

              <h4 class="text-subtitle-1 font-weight-bold mb-3">
                Organización sencilla
              </h4>

              <p class="text-body-2">
                Gestiona eventos de forma rápida e intuitiva.
              </p>

            </v-card>
          </v-col>

          <v-col
            cols="12"
            sm="6"
            md="3"
          >
            <v-card
              rounded="xl"
              elevation="2"
              class="pa-6 text-center fill-height"
            >

              <v-avatar
                size="70"
                color="green-lighten-5"
                class="mb-4"
              >
                <v-icon
                  size="34"
                  color="green-darken-2"
                >
                  mdi-earth
                </v-icon>
              </v-avatar>

              <h4 class="text-subtitle-1 font-weight-bold mb-3">
                Comunidad activa
              </h4>

              <p class="text-body-2">
                Participa en una comunidad social dinámica.
              </p>

            </v-card>
          </v-col>

        </v-row>

      </div>

    </v-container>
  </section>
</template>

<script setup lang="ts">
import community from '@/assets/community.jpg';
</script>

<style scoped>
.rounded-xl {
  border-radius: 36px;
}
</style>
