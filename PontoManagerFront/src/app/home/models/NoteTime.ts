import {EditableFieldNumber} from "./EditableFieldNumber";
import {EditableFieldTime} from "./EditableFieldTime";
import {EditableFieldDate} from "./EditableFieldDate";

export interface NoteTime {
  id: number,
  id_vsts: EditableFieldNumber,
  id_task: EditableFieldNumber,
  date: EditableFieldDate,
  start_at: EditableFieldTime,
  end_at: EditableFieldTime,
  interval: Date,
}
