export interface CounterProccess {
  success:number;
  error:number
}
export interface ProccessDataModel {
  status:boolean;
  message:string;
  counter?:CounterProccess;
}