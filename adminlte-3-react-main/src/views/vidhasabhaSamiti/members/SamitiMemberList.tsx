"use client";

import { useParams } from "next/navigation";
import { useRouter } from "@app/hooks/useCustomRouter";
import { useState } from "react";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { handleError } from "@app/utils/errorHandler";
import { ContentHeader } from "@app/components";
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
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger,
} from "@app/components/ui/dropdown-menu";
import { ConfirmDialog } from "@app/components/common/ConfirmDialog";
import { useDebounce } from "@app/hooks/useDebounce";
import { Search, Plus, MoreVertical, Trash2, Edit, Loader2 } from "lucide-react";
import { Pagination } from "@app/components/common/Pagination";
import { useQuery, useMutation, useQueryClient, keepPreviousData } from "@tanstack/react-query";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";

interface SamitiMemberListProps {
  samitiType: string;
  groupId: string;
  basePath: string;
}

const SamitiMemberList = ({ samitiType, groupId, basePath }: SamitiMemberListProps) => {
  const router = useRouter();
  const queryClient = useQueryClient();

  const [searchTerm, setSearchTerm] = useState("");
  const [entriesPerPage, setEntriesPerPage] = useState(10);
  const [currentPage, setCurrentPage] = useState(1);
  const debouncedSearchTerm = useDebounce(searchTerm, 500);

  const { data: response, isLoading, isError } = useQuery({
    queryKey: ["samiti-members", samitiType, groupId, currentPage, entriesPerPage, debouncedSearchTerm],
    queryFn: async () => {
      const params: any = {
        page: currentPage,
        limit: entriesPerPage,
        search: debouncedSearchTerm || undefined,
      };
      const { data } = await axios.get(`/samiti-members/${samitiType}/${groupId}`, { params });
      return data;
    },
    placeholderData: keepPreviousData,
  });

  const deleteMutation = useMutation({
    mutationFn: async (id: string) => {
      await axios.delete(`/samiti-members/${id}`);
    },
    onSuccess: () => {
      toast.success("Member deleted successfully");
      queryClient.invalidateQueries({ queryKey: ["samiti-members"] });
    },
    onError: (error: unknown) => {
      handleError(error, "Failed to delete member");
    },
  });

  const dataList = response?.data || [];
  const totalCount = response?.total || 0;

  return (
    <>
      <ContentHeader title="Samiti Members" />
      <section className="content">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 mt-6 overflow-hidden">
            <div className="p-6 border-b border-gray-200 dark:border-gray-800">
              <div className="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
                <div className="relative flex-1 max-w-lg">
                  <Search className="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                  <Input
                    placeholder="Search members..."
                    value={searchTerm}
                    onChange={(e) => setSearchTerm(e.target.value)}
                    className="pl-10 bg-gray-50 border-gray-200 focus:bg-white transition-all duration-200 dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200 dark:focus:bg-[#202123]"
                  />
                </div>
                <div className="flex items-center gap-3">
                  <Button
                    variant="outline"
                    onClick={() => window.history.back()}
                    className="bg-white dark:bg-[#202123] rounded-lg text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all shadow-sm"
                  >
                    Back to Samiti
                  </Button>
                  <Button
                    size="lg"
                    onClick={() => router.push(`${basePath}/${groupId}/members/create`)}
                    className="bg-[#368F8B] hover:bg-[#2d7a76] text-white rounded-lg shadow-lg shadow-[#368F8B]/20 border-0 transition-all"
                  >
                    <Plus className="w-5 h-5 mr-2" /> Add Member
                  </Button>
                </div>
              </div>
            </div>

            <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50 flex justify-end">
              <div className="flex items-center gap-2">
                <span className="text-sm font-medium text-gray-700 dark:text-gray-300">Show</span>
                <Select
                  value={entriesPerPage.toString()}
                  onValueChange={(v: string) => {
                    setEntriesPerPage(v === "-1" ? -1 : Number(v));
                    setCurrentPage(1);
                  }}
                >
                  <SelectTrigger className="w-20 h-9 bg-white dark:bg-[#202123] text-sm dark:border-gray-700 dark:text-gray-300">
                    <SelectValue placeholder="Limit" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="10">10</SelectItem>
                    <SelectItem value="20">20</SelectItem>
                    <SelectItem value="50">50</SelectItem>
                    <SelectItem value="-1">All</SelectItem>
                  </SelectContent>
                </Select>
                <span className="text-sm font-medium text-gray-700 dark:text-gray-300">entries</span>
              </div>
            </div>

            <div className="overflow-x-auto">
              <Table>
                <TableHeader>
                  <TableRow className="bg-[#368F8B] dark:bg-[#368F8B] hover:bg-transparent border-gray-200 dark:border-gray-800">
                    <TableHead className="text-white font-semibold whitespace-nowrap w-12 uppercase tracking-wider text-xs">Sr No</TableHead>
                    <TableHead className="text-white font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Name</TableHead>
                    <TableHead className="text-white font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Father's Name</TableHead>
                    <TableHead className="text-white font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Age</TableHead>
                    <TableHead className="text-white font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Position</TableHead>
                    <TableHead className="text-white font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Mobile</TableHead>
                    <TableHead className="text-white font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Remark</TableHead>
                    <TableHead className="text-white dark:text-gray-400 text-center font-semibold whitespace-nowrap uppercase tracking-wider text-xs">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {isLoading ? (
                    <TableRow>
                      <TableCell colSpan={8} className="text-center py-10">Loading...</TableCell>
                    </TableRow>
                  ) : isError ? (
                    <TableRow>
                      <TableCell colSpan={8} className="text-center py-20 text-red-500">Failed to fetch data</TableCell>
                    </TableRow>
                  ) : dataList.length === 0 ? (
                    <TableRow>
                      <TableCell colSpan={8} className="text-center py-20 text-gray-500">No members found</TableCell>
                    </TableRow>
                  ) : (
                    dataList.map((item: any, index: number) => (
                      <TableRow key={item._id} className="hover:bg-gray-50 dark:hover:bg-white/5 border-gray-100 dark:border-gray-800">
                        <TableCell className="text-center font-medium text-gray-900 dark:text-gray-100">
                          {(currentPage - 1) * (entriesPerPage === -1 ? 0 : entriesPerPage) + index + 1}
                        </TableCell>
                        <TableCell className="font-medium text-gray-900 dark:text-gray-200">{item.memberName || "N/A"}</TableCell>
                        <TableCell className="text-gray-600 dark:text-gray-400">{item.fatherName || "N/A"}</TableCell>
                        <TableCell className="text-gray-600 dark:text-gray-400">{item.age || "N/A"}</TableCell>
                        <TableCell className="text-gray-600 dark:text-gray-400">{item.position || "N/A"}</TableCell>
                        <TableCell className="text-gray-600 dark:text-gray-400">{item.mobileNumber || "N/A"}</TableCell>
                        <TableCell className="text-gray-600 dark:text-gray-400">{item.remark || "N/A"}</TableCell>
                        <TableCell className="text-center">
                          <DropdownMenu>
                            <DropdownMenuTrigger asChild>
                              <Button variant="ghost" size="icon" className="h-8 w-8">
                                <MoreVertical className="w-4 h-4" />
                              </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                              <DropdownMenuItem onClick={() => router.push(`${basePath}/${groupId}/members/${item._id}/edit`)}>
                                <Edit className="mr-2 h-4 w-4" /> Edit
                              </DropdownMenuItem>
                              <ConfirmDialog
                                onConfirm={() => deleteMutation.mutate(item._id)}
                                trigger={
                                  <div className="relative flex cursor-pointer select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-red-50 focus:bg-red-50 text-red-600 hover:text-red-700 w-full">
                                    <Trash2 className="mr-2 h-4 w-4" /> Delete
                                  </div>
                                }
                              />
                            </DropdownMenuContent>
                          </DropdownMenu>
                        </TableCell>
                      </TableRow>
                    ))
                  )}
                </TableBody>
              </Table>
            </div>

            <div className="border-t border-gray-200 dark:border-gray-800 p-6 bg-gray-50/30 dark:bg-gray-800/30">
              <div className="flex items-center justify-between">
                <p className="text-sm text-gray-600 dark:text-gray-400">
                  Showing {(currentPage - 1) * (entriesPerPage === -1 ? totalCount : entriesPerPage) + 1} to{" "}
                  {entriesPerPage === -1 ? totalCount : Math.min(currentPage * entriesPerPage, totalCount)} of {totalCount} entries
                </p>
                <div className="flex items-center gap-3">
                  <Pagination
                    currentPage={currentPage}
                    totalPages={Math.ceil(totalCount / (entriesPerPage === -1 ? totalCount || 1 : entriesPerPage))}
                    onPageChange={setCurrentPage}
                    activeColor="bg-[#00563B]"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </>
  );
};

export default SamitiMemberList;
