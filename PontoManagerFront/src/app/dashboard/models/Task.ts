import {CodeAreaEnum} from "../../enums/codeArea.enum";

export interface Task {
  idTaskType: number,
  estimatedTime: number,
  codeArea: CodeAreaEnum
}
