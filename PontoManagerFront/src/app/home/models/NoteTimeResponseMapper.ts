export interface NoteTimeResponseMapper {
  id: number,
  id_vsts: number,
  id_task: number,
  start_at: string|null,
  end_at: string|null,
  sync_at: string|null,
  created_at: string
  updated_at: string|null,
  description: string|null
}
