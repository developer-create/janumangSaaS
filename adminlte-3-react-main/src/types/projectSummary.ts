export interface IProjectFormValues {
  district: string;
  block: string;
  department: string;
  workName: string;
  projectCost: number;
  proposalEstimate: number;
  tsNoDate: string;
  asNoDate: string;
  status: string;
  officerName: string;
  contactNumber: string;
  remarks: string;
  currentProgress?: string;
}

export interface IProject {
  _id: string;
  uniqueId?: string;
  district: string;
  block: string;
  department: string;
  workName: string;
  projectCost: number;
  proposalEstimate: number;
  tsNoDate: string;
  asNoDate: string;
  status: string;
  officerName: string;
  contactNumber: string;
  technicalSession: string;
  administrativeSession: string;
  tenderStatus: string;
  companyName: string;
  contractorName: string;
  phoneNo: string;
  usdRemark: string;
  remarks: string;
  currentProgress?: string;
  lastComment?: string;
  createdAt: string;
  updatedAt?: string;
}

export interface IProjectResponse {
  data: IProject[];
  count: number;
  total: number;
  filteredCount?: number;
  page: number;
  limit: number;
}
