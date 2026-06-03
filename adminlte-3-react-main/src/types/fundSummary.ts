export interface IFundSummaryStat {
  fundKey: string;
  totalAmount: number;
  usedAmount: number;
  availableAmount: number;
}

export interface IFundSummaryStatsResponse {
  status: string;
  data: IFundSummaryStat[];
}
