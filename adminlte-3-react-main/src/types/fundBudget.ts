export interface IFundBudgetFormValues {
  financialYear: string;
  fundKey: string;
  totalAmount: number | "";
}

export interface IFundBudget {
  _id: string;
  financialYear: string;
  fundKey: string;
  totalAmount: number;
  createdAt: string;
  updatedAt?: string;
  createdBy?: {
    _id: string;
    name: string;
    email: string;
  };
}

export interface IFundBudgetResponse {
  status: string;
  results: number;
  data: IFundBudget[];
  total: number;
  page: number;
  limit: number;
}
