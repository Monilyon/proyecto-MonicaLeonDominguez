
import { ref, onMounted } from 'vue';
import { eventService } from '@/services/eventServices';
import type { MyEvent } from '@/types/Event';

export function useEvents(limit: number | null = 5) {
  const events = ref<MyEvent[]>([]);
  const loading = ref(true);
  const error = ref<string | null>(null);

  const fetchEvents = async () => {
    loading.value = true;
    try {
      const data = await eventService.getNextEvents();
      let processedData = [...data];
      // Filtro para que no salgan eventos pasados.
     processedData = processedData.filter(event => event.date !== undefined);

      //Ordenar por fecha
      processedData.sort((a, b) => {
        return new Date(a.date!).getTime() - new Date(b.date!).getTime();
      });
      // Aqui se aplica el límite SOLO si se ha especificado uno
      if (limit !== null) {
        processedData = processedData.slice(0, limit);
      }

      events.value = processedData;
    } catch (err) {
      error.value = err instanceof Error ? err.message : 'Error';
    } finally {
      loading.value = false;
    }
  };

  onMounted(fetchEvents);
  return { events, loading, error, fetchEvents };
}
