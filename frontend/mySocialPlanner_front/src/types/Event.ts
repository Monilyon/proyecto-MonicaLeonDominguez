export interface MyEvent {
  id: number;
  name: string;
  description?: string;
  date: string;
  location: string;
  capacity: number;
  registrations_count?: number;
  id_type: number;
  type?: {
    id: number;
    name: string;
  };
}
export const EVENT_TYPE_COLORS: Record<number, { label: string; color: string; icon:string;}> = {
  1: {label: "Ocio", color:"bg-pink-lighten-4", icon:"mdi-party-popper"},
  2: {label: "Deporte", color:"bg-green-lighten-4", icon:"mdi-basketball"},
  3: {label: "Cultura", color:"bg-orange-lighten-4", icon:"mdi-bank"},
  4: {label: "Accion social", color:"bg-cyan-lighten-4", icon:"mdi-hand-heart"},
};
