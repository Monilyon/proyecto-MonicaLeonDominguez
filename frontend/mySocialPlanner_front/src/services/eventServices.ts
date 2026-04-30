// const API_URL = 'http://localhost:8000/api';
import type { MyEvent } from '@/types/Event'
export const eventService = {
  async getNextEvents(): Promise<MyEvent[]> {
    const response = await fetch('http://localhost:8000/api/events')
    const result = await response.json()

    if (result && Array.isArray(result.data)) {
      return result.data
    }

    if (Array.isArray(result)) {
      return result
    }

    return []
  },
}
