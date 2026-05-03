<template>
  <v-card class="w-100" flat>
    <v-row no-gutters>
      <v-col cols="12" class="d-flex flex-column w-100 align-center justify-center ">
        <h2 class="font-weight-boldalign-center mb-0">Explora Nuestras categorías</h2>
        <p class="text-subtitle-1 text-center">
          Descubre eventos según tus intereses y encuentra experiencias que se adapten a ti.
        </p>
      </v-col>
    </v-row>
    <CategoriesCard />
  </v-card>

</template>

<script setup lang="ts">
import CategoriesCard from './CategoriesCard.vue'
</script>

<style scoped></style>
