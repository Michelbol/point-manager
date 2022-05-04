import {Task} from "./Task";

export interface NoteTime {
  id: number,
  id_vsts: number,
  id_task: number,
  date: Date,
  start_at: Date,
  end_at: Date,
  interval: Date,
  description: string|null,
  task: Task,
  isIdle(): boolean
}
