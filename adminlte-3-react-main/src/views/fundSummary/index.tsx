"use client";

import { useState, useEffect } from "react";
import { useSearchParams, useRouter } from "next/navigation";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@app/components/ui/table";
import { Input } from "@app/components/ui/input";
import { Button } from "@app/components/ui/button";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { toast } from "react-toastify";
import { Loader2, LayoutGrid, Filter, IndianRupee, RefreshCw, FileDown } from "lucide-react";
import { IFundSummaryStat } from "@app/types/fundSummary";
import api from "@app/utils/axios";
import { Pagination } from "@app/components/common/Pagination";
import { Badge } from "@app/components/ui/badge";

export default function FundSummaryList() {
  const router = useRouter();
  const searchParams = useSearchParams();
  
  const [stats, setStats] = useState<IFundSummaryStat[]>([]);
  const [statsLoading, setStatsLoading] = useState(true);

  const [data, setData] = useState<any[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [isError, setIsError] = useState(false);
  const [totalCount, setTotalCount] = useState(0);

  const [currentPage, setCurrentPage] = useState(1);
  const [entriesPerPage, setEntriesPerPage] = useState(20);

  // Filters
  const defaultFy = searchParams.get("financial_year") || "2026-2027";
  const [filterRegistrationNo, setFilterRegistrationNo] = useState("");
  const [filterFundType, setFilterFundType] = useState("all");
  const [filterFinancialYear, setFilterFinancialYear] = useState(defaultFy);
  const [filterFromDate, setFilterFromDate] = useState("");
  const [filterToDate, setFilterToDate] = useState("");
  const [filterStatus, setFilterStatus] = useState("all");

  const fundKeys = [
    { value: "MLA FUND", label: "MLA FUND" },
    { value: "MLA Sweechanudan", label: "Swecha Nidhi" },
    { value: "CLP Sweechanudan", label: "CLP Fund" },
    { value: "Jansampark Fund", label: "Jansampark Fund" },
  ];

  const getStatusVariant = (status: string): "default" | "destructive" | "outline" | "secondary" => {
    switch (status?.toLowerCase()) {
      case "complete":
      case "completed":
        return "default";
      case "in progress":
        return "secondary";
      case "reject":
      case "rejected":
        return "destructive";
      default:
        return "outline";
    }
  };

  const years = Array.from({ length: 30 }, (_, i) => {
    const year = 2008 + i;
    return `${year}-${year + 1}`;
  }).reverse();

  const fetchStats = async () => {
    try {
      setStatsLoading(true);
      const res = await api.get(`/fund-summary/stats`, {
        params: { financialYear: filterFinancialYear !== "all" ? filterFinancialYear : undefined }
      });
      setStats(res.data.data);
    } catch (error) {
      console.error("Failed to fetch stats", error);
    } finally {
      setStatsLoading(false);
    }
  };

  const fetchData = async () => {
    try {
      setIsLoading(true);
      setIsError(false);

      const params = new URLSearchParams();
      params.append("page", currentPage.toString());
      params.append("limit", entriesPerPage.toString());

      // If "all" funds is selected, we only show issues belonging to the 4 tracked funds
      if (filterFundType !== "all") {
        params.append("approvedFund", filterFundType);
      } else {
        // Send a custom parameter that the backend understands as "tracked funds only"
        params.append("approvedFundIn", "MLA FUND,MLA Sweechanudan,CLP Sweechanudan,Jansampark Fund");
      }

      if (filterFinancialYear !== "all") params.append("year", filterFinancialYear);
      if (filterRegistrationNo) params.append("uniqueId", filterRegistrationNo);
      if (filterStatus !== "all") params.append("status", filterStatus);
      if (filterFromDate) params.append("startDate", filterFromDate);
      if (filterToDate) params.append("endDate", filterToDate);

      const res = await api.get(`/fund-summary/list?${params.toString()}`);
      setData(res.data.data);
      setTotalCount(res.data.total);
    } catch (error) {
      setIsError(true);
      toast.error("Failed to fetch data");
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchStats();
    fetchData();
  }, [currentPage, entriesPerPage, filterFundType, filterFinancialYear, filterFromDate, filterToDate, filterStatus, filterRegistrationNo]);

  const handleReset = () => {
    setFilterRegistrationNo("");
    setFilterFundType("all");
    setFilterFinancialYear(defaultFy);
    setFilterFromDate("");
    setFilterToDate("");
    setFilterStatus("all");
    setCurrentPage(1);
  };

  return (
    <div className="p-4 md:p-8 pt-6 min-h-screen space-y-6">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
            <IndianRupee className="w-6 h-6 text-[#368F8B]" />
            Approved Fund Summary (FY: {filterFinancialYear === "all" ? "All FY" : filterFinancialYear})
          </h1>
          <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
            View allocated vs used budget and filter funded projects.
          </p>
        </div>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {statsLoading ? (
          Array(4).fill(0).map((_, i) => (
            <div key={i} className="bg-white dark:bg-gray-900 rounded-xl shadow p-6 h-32 animate-pulse flex items-center justify-center">
              <Loader2 className="w-6 h-6 animate-spin text-gray-400" />
            </div>
          ))
        ) : (
          fundKeys.map((fk) => {
            const stat = stats.find(s => s.fundKey === fk.value);
            return (
              <div key={fk.value} className="bg-white dark:bg-gray-900 rounded-xl shadow-lg border-l-4 border-[#368F8B] p-6 transition-all hover:shadow-xl hover:-translate-y-1">
                <div className="flex items-center gap-4">
                  <div className="bg-[#368F8B]/10 p-3 rounded-full text-[#368F8B]">
                    <IndianRupee className="w-6 h-6" />
                  </div>
                  <div>
                    <p className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                      {fk.label}
                    </p>
                    <div className="mt-2 space-y-1 text-sm text-gray-700 dark:text-gray-300">
                      <div className="flex justify-between">
                        <span>Total:</span>
                        <span className="font-medium">₹{stat?.totalAmount.toLocaleString("en-IN") || 0}</span>
                      </div>
                      <div className="flex justify-between">
                        <span>Used:</span>
                        <span className="font-medium text-amber-600">₹{stat?.usedAmount.toLocaleString("en-IN") || 0}</span>
                      </div>
                      <div className="flex justify-between pt-1 border-t">
                        <span className="font-medium">Avail:</span>
                        <span className="font-bold text-emerald-600">₹{stat?.availableAmount.toLocaleString("en-IN") || 0}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            );
          })
        )}
      </div>

      {/* Filters and Table */}
      <div className="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div className="p-6 border-b border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-4">
            <div className="space-y-1.5">
              <label className="text-xs font-medium text-gray-700 dark:text-gray-300">Regi No</label>
              <Input
                placeholder="Search Regi No"
                value={filterRegistrationNo}
                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setFilterRegistrationNo(e.target.value)}
                className="bg-white dark:bg-gray-900"
              />
            </div>
            <div className="space-y-1.5">
              <label className="text-xs font-medium text-gray-700 dark:text-gray-300">Fund Type</label>
              <Select value={filterFundType} onValueChange={setFilterFundType}>
                <SelectTrigger className="bg-white dark:bg-gray-900">
                  <SelectValue placeholder="All Funds" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Funds</SelectItem>
                  {fundKeys.map((fk) => (
                    <SelectItem key={fk.value} value={fk.value}>
                      {fk.value}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
            <div className="space-y-1.5">
              <label className="text-xs font-medium text-gray-700 dark:text-gray-300">Financial Year</label>
              <Select value={filterFinancialYear} onValueChange={setFilterFinancialYear}>
                <SelectTrigger className="bg-white dark:bg-gray-900">
                  <SelectValue placeholder="All FY" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All FY</SelectItem>
                  {years.map((y) => (
                    <SelectItem key={y} value={y}>
                      {y}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>
            <div className="space-y-1.5">
              <label className="text-xs font-medium text-gray-700 dark:text-gray-300">From Date</label>
              <Input
                type="date"
                value={filterFromDate}
                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setFilterFromDate(e.target.value)}
                className="bg-white dark:bg-gray-900"
              />
            </div>
            <div className="space-y-1.5">
              <label className="text-xs font-medium text-gray-700 dark:text-gray-300">To Date</label>
              <Input
                type="date"
                value={filterToDate}
                onChange={(e: React.ChangeEvent<HTMLInputElement>) => setFilterToDate(e.target.value)}
                className="bg-white dark:bg-gray-900"
              />
            </div>
            <div className="space-y-1.5">
              <label className="text-xs font-medium text-gray-700 dark:text-gray-300">Status</label>
              <Select value={filterStatus} onValueChange={setFilterStatus}>
                <SelectTrigger className="bg-white dark:bg-gray-900">
                  <SelectValue placeholder="All Status" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Status</SelectItem>
                  <SelectItem value="Incomplete">Incomplete</SelectItem>
                  <SelectItem value="In progress">In Progress</SelectItem>
                  <SelectItem value="Complete">Complete</SelectItem>
                  <SelectItem value="Reject">Reject</SelectItem>
                </SelectContent>
              </Select>
            </div>
            <div className="space-y-1.5 flex gap-2 items-end">
              <Button onClick={handleReset} variant="outline" className="w-full">
                <RefreshCw className="w-4 h-4 mr-2" /> Reset
              </Button>
            </div>
          </div>
        </div>

        <div className="overflow-x-auto">
          <Table>
            <TableHeader>
              <TableRow className="bg-[#020254] hover:bg-[#020254] border-gray-200 dark:border-gray-800">
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Sr No</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Regi No</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Recommended Letter No</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Financial Year</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Name</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Mobile</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">District</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Block</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Department</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Work/Problem</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Status</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Approved Fund</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap text-right">Approximate Cost</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Work Agency</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Remark</TableHead>
                <TableHead className="font-semibold text-white uppercase tracking-wider text-xs whitespace-nowrap">Date</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              {isLoading ? (
                <TableRow>
                  <TableCell colSpan={16} className="text-center py-10">
                    <Loader2 className="w-6 h-6 animate-spin mx-auto text-gray-400" />
                  </TableCell>
                </TableRow>
              ) : isError ? (
                <TableRow>
                  <TableCell colSpan={16} className="text-center py-20 text-red-500">
                    Failed to fetch data
                  </TableCell>
                </TableRow>
              ) : data.length === 0 ? (
                <TableRow>
                  <TableCell colSpan={16} className="text-center py-20 text-gray-500">
                    No data found
                  </TableCell>
                </TableRow>
              ) : (
                data.map((row, idx) => (
                  <TableRow
                    key={row._id}
                    className="hover:bg-gray-50 dark:hover:bg-white/5 border-gray-100 dark:border-gray-800"
                  >
                    <TableCell className="dark:text-gray-300">
                      {entriesPerPage === -1
                        ? idx + 1
                        : (currentPage - 1) * entriesPerPage + idx + 1}
                    </TableCell>
                    <TableCell className="dark:text-gray-300 font-medium">
                      {row.uniqueId || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.recommendedLetterNo || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.year || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.beneficiaryName || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.beneficiaryContact || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.district || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.block || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.department || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300 max-w-[200px] truncate" title={row.workProblem}>
                      {row.workProblem || "-"}
                    </TableCell>
                    <TableCell>
                      <Badge variant={getStatusVariant(row.status)}>{row.status || "Pending"}</Badge>
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.approvedFund || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300 text-right font-medium text-emerald-600">
                      ₹{(row.approximateCost || 0).toLocaleString("en-IN", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                      })}
                    </TableCell>
                    <TableCell className="dark:text-gray-300">
                      {row.workAgency || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300 max-w-[150px] truncate" title={row.remarkGoshana || row.remarkTipUsd}>
                      {row.remarkGoshana || row.remarkTipUsd || "-"}
                    </TableCell>
                    <TableCell className="dark:text-gray-300 whitespace-nowrap">
                      {row.registrationDate ? new Date(row.registrationDate).toLocaleDateString() : "-"}
                    </TableCell>
                  </TableRow>
                ))
              )}
            </TableBody>
          </Table>
        </div>

        {!isLoading && data.length > 0 && (
          <div className="border-t border-gray-200 dark:border-gray-800 p-6 bg-gray-50/30 dark:bg-gray-800/30">
            <div className="flex flex-col md:flex-row items-center justify-between gap-4">
              <p className="text-sm text-gray-600 dark:text-gray-400">
                Showing{" "}
                {entriesPerPage === -1
                  ? 1
                  : (currentPage - 1) * entriesPerPage + 1}{" "}
                to{" "}
                {entriesPerPage === -1
                  ? totalCount
                  : Math.min(currentPage * entriesPerPage, totalCount)}{" "}
                of {totalCount} entries
              </p>
              
              <div className="flex items-center gap-4">
                <div className="flex items-center gap-2">
                  <span className="text-sm text-gray-500">Show</span>
                  <Select
                    value={entriesPerPage.toString()}
                    onValueChange={(val: string) => {
                      setEntriesPerPage(Number(val));
                      setCurrentPage(1);
                    }}
                  >
                    <SelectTrigger className="w-20">
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="10">10</SelectItem>
                      <SelectItem value="20">20</SelectItem>
                      <SelectItem value="50">50</SelectItem>
                      <SelectItem value="100">100</SelectItem>
                      <SelectItem value="-1">All</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                <Pagination
                  currentPage={currentPage}
                  totalPages={Math.ceil(
                    totalCount /
                      (entriesPerPage === -1 ? totalCount || 1 : entriesPerPage)
                  )}
                  onPageChange={setCurrentPage}
                />
              </div>
            </div>
            <div className="mt-4 flex justify-end text-lg font-bold text-gray-800 dark:text-white bg-gray-100 dark:bg-gray-800 p-3 rounded">
              Total Used Fund (filtered): <span className="ml-2 text-amber-600">₹{
                data.reduce((sum, item) => sum + (Number(item.approximateCost) || 0), 0).toLocaleString("en-IN", {
                  minimumFractionDigits: 2, maximumFractionDigits: 2
                })
              }</span>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
