import {NoteTime} from "./NoteTime";
import {DateService} from "../../services/date.service";
import {Injectable} from "@angular/core";

@Injectable({
  providedIn: 'root'
})
export class NoteTimeFactory {
  constructor(public dateService: DateService) { }

  create(id: number, date: Date): NoteTime {
    return {
      id: id+1,
      id_vsts: {
        value: 1,
        editable: false
      },
      id_task: {
        value: 1,
        editable: false
      },
      date: {
        value: date,
        editable: false
      },
      start_at: {
        value: new Date(),
        editable: false,
        string: this.dateService.formatTime(new Date())
      },
      end_at: {
        value: new Date(),
        editable: false,
        string: this.dateService.formatTime(new Date())
      },
      interval: new Date
    };
  }
}
