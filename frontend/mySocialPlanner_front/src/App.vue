<template>
  <v-app>
    <TheHeader />

    <v-main>
      <router-view />
      <CookieBanner />
    </v-main>
    <TheFooter />
  </v-app>
</template>

<script setup lang="ts">
import TheHeader from '@/components/TheHeader.vue';
import TheFooter from './components/TheFooter.vue';
import CookieBanner from './components/CookieBanner.vue';
</script>

<style scope>

</style>
