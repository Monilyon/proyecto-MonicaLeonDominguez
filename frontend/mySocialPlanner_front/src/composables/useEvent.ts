// src/composables/useEvents.ts
import { ref, onMounted } from 'vue';
import { eventService } from '@/services/eventServices';
import type { MyEvent } from '@/types/Event';

export function useEvents() {
  const events = ref<MyEvent[]>([]);
  const loading = ref(true);
  const error = ref<string | null>(null);

  const fetchEvents = async () => {
    loading.value = true;
    try {
      const data = await eventService.getNextEvents();
      events.value = data.slice(0, 5);
    } catch (err) {
      error.value = err instanceof Error ? err.message : 'Error';
    } finally {
      loading.value = false;
    }
  };

  onMounted(fetchEvents);
  return { events, loading, error };
}
