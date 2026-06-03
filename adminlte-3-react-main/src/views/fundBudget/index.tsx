"use client";

import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@app/components/ui/table";
import { Button } from "@app/components/ui/button";
import { Input } from "@app/components/ui/input";
import { toast } from "react-toastify";
import {
  Loader2,
  Plus,
  Search,
  MoreVertical,
  Edit,
  Trash2,
  LayoutGrid,
  Filter,
} from "lucide-react";
import { IFundBudget } from "@app/types/fundBudget";
import api from "@app/utils/axios";
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@app/components/ui/dropdown-menu";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { ConfirmDialog } from "@app/components/common/ConfirmDialog";
import { Pagination } from "@app/components/common/Pagination";

export default function FundBudgetList() {
  const router = useRouter();
  const [budgets, setBudgets] = useState<IFundBudget[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [isError, setIsError] = useState(false);
  const [searchTerm, setSearchTerm] = useState("");
  const [filterFundKey, setFilterFundKey] = useState("all");
  const [filterYear, setFilterYear] = useState("all");
  const [currentPage, setCurrentPage] = useState(1);
  const [totalCount, setTotalCount] = useState(0);
  const [entriesPerPage, setEntriesPerPage] = useState(20);

  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [budgetToDelete, setBudgetToDelete] = useState<string | null>(null);

  const fundKeys = [
    "MLA FUND",
    "MLA Sweechanudan",
    "CLP Sweechanudan",
    "Jansampark Fund",
  ];

  const years = Array.from({ length: 30 }, (_, i) => {
    const year = 2008 + i;
    return `${year}-${year + 1}`;
  }).reverse();

  const fetchBudgets = async () => {
    try {
      setIsLoading(true);
      setIsError(false);

      const params = new URLSearchParams();
      params.append("page", currentPage.toString());
      params.append("limit", entriesPerPage.toString());

      if (filterFundKey !== "all") params.append("fundKey", filterFundKey);
      if (filterYear !== "all") params.append("financialYear", filterYear);

      const res = await api.get(`/fund-budgets?${params.toString()}`);
      setBudgets(res.data.data);
      setTotalCount(res.data.total);
    } catch (error) {
      console.error("Failed to fetch budgets:", error);
      setIsError(true);
      toast.error("Failed to fetch fund budgets");
    } finally {
      setIsLoading(false);
    }
  };

  useEffect(() => {
    fetchBudgets();
  }, [currentPage, entriesPerPage, filterFundKey, filterYear]);

  const handleDelete = async () => {
    if (!budgetToDelete) return;

    try {
      await api.delete(`/fund-budgets/${budgetToDelete}`);
      toast.success("Fund Budget deleted successfully");
      fetchBudgets();
    } catch (error: any) {
      toast.error(
        error.response?.data?.message || "Failed to delete budget"
      );
    } finally {
      setDeleteModalOpen(false);
      setBudgetToDelete(null);
    }
  };

  const confirmDelete = (id: string) => {
    setBudgetToDelete(id);
    setDeleteModalOpen(true);
  };

  return (
    <div className="p-4 md:p-8 pt-6 min-h-screen">
      <div className="max-w-[1600px] mx-auto space-y-6">
        <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
              <LayoutGrid className="w-6 h-6 text-[#368F8B]" />
              Fund Budget Limits
            </h1>
            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
              Manage budget allocations for different funds and financial years.
            </p>
          </div>
          <div className="flex flex-wrap items-center gap-3">
            <Button
              className="bg-[#368F8B] hover:bg-[#2A706D] text-white shadow-md transition-all duration-200"
              onClick={() => router.push("/fund-budget/create")}
            >
              <Plus className="w-4 h-4 mr-2" />
              Add Budget
            </Button>
          </div>
        </div>

        <div className="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 overflow-hidden">
          <div className="p-6 border-b border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50 flex flex-col md:flex-row gap-4 justify-between items-center">
            <div className="flex flex-wrap gap-4 w-full md:w-auto">
              <div className="relative w-full md:w-64">
                <Search className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" />
                <Input
                  placeholder="Search..."
                  value={searchTerm}
                  onChange={(e: React.ChangeEvent<HTMLInputElement>) => setSearchTerm(e.target.value)}
                  className="pl-10 bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 w-full"
                />
              </div>

              <Select value={filterYear} onValueChange={setFilterYear}>
                <SelectTrigger className="w-full md:w-48 bg-white dark:bg-gray-900">
                  <Filter className="w-4 h-4 mr-2 text-gray-400" />
                  <SelectValue placeholder="All Financial Years" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Financial Years</SelectItem>
                  {years.map((y) => (
                    <SelectItem key={y} value={y}>
                      {y}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>

              <Select value={filterFundKey} onValueChange={setFilterFundKey}>
                <SelectTrigger className="w-full md:w-48 bg-white dark:bg-gray-900">
                  <Filter className="w-4 h-4 mr-2 text-gray-400" />
                  <SelectValue placeholder="All Funds" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="all">All Funds</SelectItem>
                  {fundKeys.map((fk) => (
                    <SelectItem key={fk} value={fk}>
                      {fk}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
            </div>

            <div className="flex items-center gap-3 w-full md:w-auto justify-end">
              <span className="text-sm text-gray-500 whitespace-nowrap">Show</span>
              <Select
                value={entriesPerPage.toString()}
                onValueChange={(val: string) => setEntriesPerPage(Number(val))}
              >
                <SelectTrigger className="w-20 bg-white dark:bg-gray-900">
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
              <span className="text-sm text-gray-500 whitespace-nowrap">entries</span>
            </div>
          </div>

          <div className="overflow-x-auto">
            <Table>
              <TableHeader>
                <TableRow className="bg-[#020254] hover:bg-[#020254] border-gray-200 dark:border-gray-800">
                  <TableHead className="font-semibold text-white uppercase tracking-wider text-xs">
                    Sr No
                  </TableHead>
                  <TableHead className="font-semibold text-white uppercase tracking-wider text-xs">
                    Financial Year
                  </TableHead>
                  <TableHead className="font-semibold text-white uppercase tracking-wider text-xs">
                    Fund Name
                  </TableHead>
                  <TableHead className="font-semibold text-white uppercase tracking-wider text-xs text-right">
                    Total Amount (₹)
                  </TableHead>
                  <TableHead className="font-semibold text-white uppercase tracking-wider text-xs text-right">
                    Created At
                  </TableHead>
                  <TableHead className="font-semibold text-white uppercase tracking-wider text-xs text-right">
                    Actions
                  </TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {isLoading ? (
                  <TableRow>
                    <TableCell colSpan={6} className="text-center py-10">
                      <Loader2 className="w-6 h-6 animate-spin mx-auto text-gray-400" />
                    </TableCell>
                  </TableRow>
                ) : isError ? (
                  <TableRow>
                    <TableCell colSpan={6} className="text-center py-20 text-red-500">
                      Failed to fetch budgets
                    </TableCell>
                  </TableRow>
                ) : budgets.length === 0 ? (
                  <TableRow>
                    <TableCell colSpan={6} className="text-center py-20 text-gray-500">
                      No fund budget limits found
                    </TableCell>
                  </TableRow>
                ) : (
                  budgets.map((budget, idx) => (
                    <TableRow
                      key={budget._id}
                      className="hover:bg-gray-50 dark:hover:bg-white/5 border-gray-100 dark:border-gray-800"
                    >
                      <TableCell className="dark:text-gray-300">
                        {entriesPerPage === -1
                          ? idx + 1
                          : (currentPage - 1) * entriesPerPage + idx + 1}
                      </TableCell>
                      <TableCell className="dark:text-gray-300 font-medium">
                        {budget.financialYear}
                      </TableCell>
                      <TableCell className="dark:text-gray-300 font-medium">
                        {budget.fundKey}
                      </TableCell>
                      <TableCell className="dark:text-gray-300 text-right font-medium">
                        ₹{budget.totalAmount.toLocaleString("en-IN", {
                          minimumFractionDigits: 2,
                          maximumFractionDigits: 2,
                        })}
                      </TableCell>
                      <TableCell className="dark:text-gray-300 text-right">
                        {new Date(budget.createdAt).toLocaleDateString()}
                      </TableCell>
                      <TableCell className="text-right">
                        <DropdownMenu>
                          <DropdownMenuTrigger asChild>
                            <Button variant="ghost" size="icon" className="h-8 w-8">
                              <MoreVertical className="w-4 h-4" />
                            </Button>
                          </DropdownMenuTrigger>
                          <DropdownMenuContent align="end">
                            <DropdownMenuItem
                              onClick={() =>
                                router.push(`/fund-budget/${budget._id}/edit`)
                              }
                            >
                              <Edit className="mr-2 h-4 w-4" /> Edit
                            </DropdownMenuItem>
                            <DropdownMenuItem
                              className="text-destructive focus:text-destructive"
                              onClick={() => confirmDelete(budget._id)}
                            >
                              <Trash2 className="mr-2 h-4 w-4" /> Delete
                            </DropdownMenuItem>
                          </DropdownMenuContent>
                        </DropdownMenu>
                      </TableCell>
                    </TableRow>
                  ))
                )}
              </TableBody>
            </Table>
          </div>

          {!isLoading && budgets.length > 0 && (
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
          )}
        </div>
      </div>
      <ConfirmDialog
        isOpen={deleteModalOpen}
        onOpenChange={setDeleteModalOpen}
        onConfirm={handleDelete}
        title="Delete Fund Budget"
        description="Are you sure you want to delete this fund budget limit? This action cannot be undone."
      />
    </div>
  );
}
