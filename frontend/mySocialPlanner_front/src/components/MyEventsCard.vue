<template>
  <v-card
    variant="flat"
    :class="['pa-3 mb-4 rounded-xl', EVENT_TYPE_COLORS[registration.event.id_type]?.color,
    { 'is-rejected': registration.status.name.toLowerCase().includes('rechazada') }
  ]"

  >
    <v-row no-gutters align="center">
      <v-col cols="auto" class="mr-4">
        <v-sheet
          color="grey-lighten-2"
          width="80"
          height="80"
          class="rounded-lg d-flex align-center justify-center"
        >
          <v-icon size="36" color="grey-darken-1">
            {{ EVENT_TYPE_COLORS[registration.event.id_type]?.icon }}
          </v-icon>
        </v-sheet>
      </v-col>

      <v-col>
        <div class="text-subtitle-1 font-weight-bold line-height-tight">
          {{ registration.event.name }}
        </div>
        <div class="text-caption text-grey-darken-3 mt-1">
          {{ registration.event.location }}
        </div>
        <div class="text-caption text-grey-darken-3">
          {{ formatDate(registration.event.date) }}
        </div>
      </v-col>

      <v-col cols="auto" class="d-flex flex-column align-end">
        <v-chip
          :color="statusColor"
          size="x-small"
          variant="flat"
          class="text-uppercase font-weight-bold mb-2"
        >
          {{ registration.status.name }}
        </v-chip>

        <v-btn
          v-if="canCancel"
          size="x-small"
          rounded
          color="white"
          @click="handleCancel"
          :loading="cancelling"
          style="font-weight: bolder;"
        >
          Anular inscripción
        </v-btn>

        <div class="registration-date">
          Inscripción: {{ formatDate(registration.registration_date || registration.event.date) }}
        </div>
      </v-col>
    </v-row>
  </v-card>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import type { MyRegistration } from '@/types/Registration';
import { EVENT_TYPE_COLORS } from '@/types/Event';

const props = defineProps<{ registration: MyRegistration }>();
const emit = defineEmits<{
  cancel: [registrationId: number];
}>();

const cancelling = ref(false);

const canCancel = computed(() => {
  const statusName = props.registration.status.name.toLowerCase();
  return !statusName.includes('cancelada') && !statusName.includes('rechazada');
});

const handleCancel = async () => {
  cancelling.value = true;
  try {
    emit('cancel', props.registration.id);
  } finally {
    cancelling.value = false;
  }
};

const statusColor = computed(() => {
  const statusName = props.registration.status.name.toLowerCase();
  if (statusName.includes('pendiente')) return 'orange-darken-2';
  if (statusName.includes('aprobada')) return 'green-darken-2';
  if (statusName.includes('rechazada')) return 'red-darken-2';
  if (statusName.includes('cancelada')) return 'grey-darken-2';
  console.log(props.registration.status.name);

  return 'blue-darken-2';
});

const formatDate = (value: string) => {
  return new Date(value).toLocaleDateString('es-ES', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};
</script>

<style scoped>
.line-height-tight {
  line-height: 1.2;
}

.registration-date {
  font-size: 0.85rem;
  color: #116ac3;
  font-weight: bold;
}

.rounded-xl {
  border-radius: 24px !important;
}
.is-rejected {
  background-color: #e0e0e0 !important;
}
</style>
