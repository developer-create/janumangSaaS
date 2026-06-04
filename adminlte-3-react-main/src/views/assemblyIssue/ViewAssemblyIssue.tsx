"use client";

import { useEffect, useState } from "react";
import { useRouter } from "@app/hooks/useCustomRouter";
import { useParams } from "next/navigation";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { handleError } from "@app/utils/errorHandler";

import { Button } from "@app/components/ui/button";
import { Badge } from "@app/components/ui/badge";
import { ContentHeader } from "@app/components";
import { RouteGuard } from "@app/components/RouteGuard";
import { PERMISSIONS } from "@app/config/permissions";

interface ViewAssemblyIssueProps {
  issueType?: string;
  title?: string;
  basePath?: string;
}

const ViewAssemblyIssue = ({
  issueType = "assembly-issue",
  title = "View Assembly Issue",
  basePath = "/assembly-issue",
}: ViewAssemblyIssueProps) => {
  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.VIEW_ASSEMBLY_ISSUES]}>
      <ViewAssemblyIssueContent
        issueType={issueType}
        title={title}
        basePath={basePath}
      />
    </RouteGuard>
  );
};

import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
} from "@app/components/ui/dialog";
import { ViewPageActions } from "@app/components/ViewPageActions";
import { ArrowLeft, Edit, FileImage, MessageSquare, Plus, Clock, Upload } from "lucide-react";
import { API_BASE_URL } from "@app/utils/api";
import { Label } from "@app/components/ui/label";
import { Input } from "@app/components/ui/input";
import { Textarea } from "@app/components/ui/textarea";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";

import { IAssemblyIssue } from "@app/types/assemblyIssue";

const ViewAssemblyIssueContent = ({
  issueType,
  title,
  basePath,
}: {
  issueType: string;
  title: string;
  basePath: string;
}) => {
  const router = useRouter();
  const params = useParams();
  const { id } = params;

  const [issue, setIssue] = useState<IAssemblyIssue | null>(null);
  const [loading, setLoading] = useState(true);

  // Remarks State
  const [comments, setComments] = useState<any[]>([]);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const [remarkText, setRemarkText] = useState("");
  const [remarkStatus, setRemarkStatus] = useState("");
  const [remarkStage, setRemarkStage] = useState(issueType);
  const [remarkFile, setRemarkFile] = useState<File | null>(null);

  const fetchComments = async () => {
    try {
      const { data } = await axios.get(`/assembly-issues/${id}/comments`);
      setComments(data.data || []);
    } catch (error) {
      console.error("Failed to fetch comments", error);
    }
  };

  useEffect(() => {
    const fetchIssue = async () => {
      try {
        const { data } = await axios.get(`/assembly-issues/${id}`);
        setIssue(data.data || null);
      } catch (error: unknown) {
        handleError(error, "Failed to load assembly issue details");
        router.push(basePath);
      } finally {
        setLoading(false);
      }
    };

    if (id) {
      fetchIssue();
      fetchComments();
    }
  }, [id, router, basePath]);

  const handleAddRemark = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!remarkText.trim()) {
      toast.error("Please enter a remark");
      return;
    }
    setSubmitting(true);
    try {
      let fileUrl = "";
      let fileName = "";

      if (remarkFile) {
        const formData = new FormData();
        formData.append("file", remarkFile);
        const uploadRes = await axios.post("/upload", formData, {
          headers: { "Content-Type": "multipart/form-data" },
        });
        fileUrl = uploadRes.data.url;
        fileName = remarkFile.name;
      }

      const payload = {
        comment: remarkText,
        status: remarkStatus || issue?.status,
        issueType: remarkStage || issue?.issueType,
        fileUrl,
        fileName,
      };

      await axios.post(`/assembly-issues/${id}/comments`, payload);
      toast.success("Remark added successfully");
      
      // Reset form & Refresh data
      setRemarkText("");
      setRemarkFile(null);
      setIsModalOpen(false);
      fetchComments();
      // Refetch issue to update the status badge
      const { data } = await axios.get(`/assembly-issues/${id}`);
      setIssue(data.data || null);
    } catch (error) {
      handleError(error, "Failed to add remark");
    } finally {
      setSubmitting(false);
    }
  };

  if (loading) {
    return (
      <div className="flex flex-col items-center justify-center p-20 space-y-4 dark:bg-[#1a1c1e]">
        <div className="w-12 h-12 border-4 border-[#00563B] border-t-transparent rounded-full animate-spin"></div>
        <p className="text-gray-500 dark:text-gray-400 font-medium">
          Loading issue details...
        </p>
      </div>
    );
  }

  if (!issue) {
    return <div className="p-8 text-center">Issue not found</div>;
  }

  const DetailItem = ({
    label,
    value,
  }: {
    label: string;
    value: React.ReactNode;
  }) => (
    <div className="p-4 bg-gray-50/50 dark:bg-gray-800/20 rounded-lg border border-gray-100 dark:border-gray-800/50 transition-all hover:shadow-sm">
      <h3 className="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-1">
        {label}
      </h3>
      <div className="text-base font-semibold text-gray-800 dark:text-gray-100 wrap-break-words line-clamp-3">
        {value || "-"}
      </div>
    </div>
  );

  const getExportData = () => {
    if (!issue) return {};
    return {
      "Unique ID": issue.uniqueId,
      Year: issue.year,
      Month: issue.month,
      Date: issue.date,
      "Recommended Letter No": issue.recommendedLetterNo,

      Block: issue.block,
      Sector: issue.sectorName,
      "Micro Sector No": issue.microSectorNo,
      "Micro Sector Name": issue.microSectorName,
      "Booth Name": issue.boothName,
      "Booth No": issue.boothNo,
      "Panchayat Name": issue.panchayatName,
      Village: issue.village,
      "Majra/Faliya": issue.majraFaliya,

      "Created At": issue.createdAt,
      "Updated At": issue.updatedAt,
      Description:
        "Assembly issue details including sector and booth information.",
    };
  };

  return (
    <>
      <ContentHeader title={title} />

      <section className="content">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-xl border border-gray-200 dark:border-gray-800 mt-6 max-w-5xl mx-auto overflow-hidden">
            <div className="p-6 border-b border-gray-200 dark:border-gray-800 flex flex-wrap justify-between items-center gap-4 bg-gray-50/50 dark:bg-gray-800/30">
              <h2 className="text-xl font-bold text-gray-800 dark:text-gray-100">
                Assembly Issue Details
              </h2>
              <div className="flex gap-2 items-center">
                <ViewPageActions
                  getExportData={getExportData}
                  fileName={`AssemblyIssue_${issue.uniqueId}`}
                />

                <Button
                  variant="outline"
                  onClick={() => router.push(basePath)}
                  className="dark:bg-[#202123] dark:text-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all shadow-sm rounded-lg"
                >
                  <ArrowLeft className="w-4 h-4 mr-2" />
                  Back to List
                </Button>
              </div>
            </div>

            <div className="p-8 space-y-8">
              {/* Header Info */}
              <div className="flex flex-col md:flex-row justify-between items-start border-b border-gray-100 dark:border-gray-800 pb-8">
                <div>
                  <h1 className="text-3xl font-black text-gray-900 dark:text-gray-50 border-l-4 border-[#00563B] pl-4 tracking-tight">
                    {issue.uniqueId}
                  </h1>
                  <p className="text-gray-500 dark:text-gray-400 mt-2 pl-5 flex items-center gap-2">
                    <span className="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                    Created on{" "}
                    {new Date(issue.createdAt).toLocaleDateString("en-IN", {
                      day: "2-digit",
                      month: "long",
                      year: "numeric",
                    })}
                  </p>
                </div>
                <div className="mt-4 md:mt-0 flex gap-2">
                  <Badge
                    variant="outline"
                    className="text-sm px-4 py-2 border-slate-200 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-800/50 font-bold rounded-full shadow-sm"
                  >
                    Year: {issue.year}
                  </Badge>
                  <Badge
                    variant="outline"
                    className="text-sm px-4 py-2 border-slate-200 dark:border-gray-700 dark:text-gray-300 dark:bg-gray-800/50 font-bold rounded-full shadow-sm"
                  >
                    {issue.month}
                  </Badge>
                </div>
              </div>

              {/* Details Grid */}
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <DetailItem label="Month" value={issue.month} />
                <DetailItem label="Date" value={issue.date} />
                <DetailItem
                  label="Recommended Letter No"
                  value={issue.recommendedLetterNo}
                />
                
                <DetailItem label="Block" value={issue.block} />
                <DetailItem label="Sector" value={issue.sectorName} />
                <DetailItem
                  label="Micro Sector No"
                  value={issue.microSectorNo}
                />
                <DetailItem
                  label="Micro Sector Name"
                  value={issue.microSectorName}
                />
                <DetailItem label="Booth Name" value={issue.boothName} />
                <DetailItem label="Booth No" value={issue.boothNo} />
                <DetailItem
                  label="Panchayat Name"
                  value={issue.panchayatName}
                />
                <DetailItem label="Village" value={issue.village} />
                <DetailItem label="Majra/Faliya" value={issue.majraFaliya} />
                
                <DetailItem label="Status" value={issue.status} />
                <DetailItem label="Added By" value={issue.addedBy} />
                <DetailItem
                  label="Lat/Lng"
                  value={(() => {
                    const parts = (
                      issue.latLng || "0.00000000, 0.00000000"
                    ).split(",");
                    return (
                      <div className="flex flex-col">
                        <span>{parts[0]?.trim()}</span>
                        <span>{parts[1]?.trim()}</span>
                      </div>
                    );
                  })()}
                />
                <DetailItem
                  label="Registration Date"
                  value={
                    issue.registrationDate
                      ? new Date(issue.registrationDate).toLocaleDateString()
                      : "-"
                  }
                />

                <div className="col-span-1 md:col-span-2 lg:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-8">
                  <div className="space-y-3">
                    <h3 className="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                      Avedan File
                    </h3>
                    <div className="p-4 bg-gray-50 dark:bg-gray-800/20 rounded-xl border border-gray-200 dark:border-gray-700 min-h-[100px] flex items-center justify-center">
                      {issue.avedanFile ? (
                        <div className="text-center">
                          <a
                            href={
                              issue.avedanFile.startsWith("/")
                                ? `${API_BASE_URL.replace("/api", "")}${issue.avedanFile}`
                                : issue.avedanFile
                            }
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex flex-col items-center gap-2 text-[#368F8B] hover:text-[#2d7a76] font-bold transition-all"
                          >
                            <FileImage className="w-12 h-12" />
                            <span>View Avedan</span>
                            <span className="text-xs text-gray-400 font-normal">
                              {issue.avedanFileName || "View Attachment"}
                            </span>
                          </a>
                        </div>
                      ) : (
                        <p className="text-gray-400 dark:text-gray-500 italic">
                          No Avedan attached
                        </p>
                      )}
                    </div>
                  </div>

                  <div className="space-y-3">
                    <h3 className="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">
                      Documents Set
                    </h3>
                    <div className="p-4 bg-gray-50 dark:bg-gray-800/20 rounded-xl border border-gray-200 dark:border-gray-700 min-h-[100px] flex items-center justify-center">
                      {issue.documentFile ? (
                        <div className="text-center">
                          <a
                            href={
                              issue.documentFile.startsWith("/")
                                ? `${API_BASE_URL.replace("/api", "")}${issue.documentFile}`
                                : issue.documentFile
                            }
                            target="_blank"
                            rel="noreferrer"
                            className="inline-flex flex-col items-center gap-2 text-[#00563B] hover:text-[#368F8B] font-bold transition-all"
                          >
                            <FileImage className="w-12 h-12" />
                            <span>View Documents</span>
                            <span className="text-xs text-gray-400 font-normal">
                              {issue.documentFileName || "View PDF"}
                            </span>
                          </a>
                        </div>
                      ) : (
                        <p className="text-gray-400 dark:text-gray-500 italic">
                          No documents attached
                        </p>
                      )}
                    </div>
                  </div>
                </div>
              </div>

              {/* Update Info */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                <span className="text-xs text-gray-400 dark:text-gray-500">
                  Last updated:{" "}
                  {new Date(issue.updatedAt).toLocaleString("en-IN")}
                </span>

                <div className="flex gap-3">
                  <Button
                    onClick={() => setIsModalOpen(true)}
                    variant="outline"
                    className="border-[#368F8B] text-[#368F8B] hover:bg-[#368F8B] hover:text-white transition-colors"
                  >
                    <MessageSquare className="w-4 h-4 mr-2" />
                    Add Remark
                  </Button>
                  <Button
                    onClick={() => router.push(`${basePath}/${issue._id}/edit`)}
                    className="bg-[#368F8B] hover:bg-[#2d7a76] text-white rounded-lg shadow-lg shadow-[#368F8B]/20 border-0 transition-all min-w-[140px] font-bold"
                  >
                    <Edit className="w-4 h-4 mr-2" />
                    Edit Details
                  </Button>
                </div>
              </div>

              {/* Follow-up Timeline */}
              <div className="pt-8 border-t border-gray-100 dark:border-gray-800">
                <h2 className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
                  <Clock className="w-5 h-5 text-[#368F8B]" />
                  Follow-up Timeline
                </h2>
                
                {comments.length === 0 ? (
                  <div className="p-8 text-center bg-gray-50/50 dark:bg-gray-800/20 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                    <MessageSquare className="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" />
                    <p className="text-gray-500 dark:text-gray-400 font-medium">No remarks or follow-ups yet.</p>
                    <p className="text-sm text-gray-400 dark:text-gray-500 mt-1">Add a remark to track the progress of this issue.</p>
                  </div>
                ) : (
                  <div className="space-y-6">
                    {comments.map((comment, index) => (
                      <div key={comment._id} className="relative pl-8 pb-6 last:pb-0">
                        {/* Timeline line */}
                        {index !== comments.length - 1 && (
                          <div className="absolute left-[11px] top-8 bottom-0 w-[2px] bg-gray-100 dark:bg-gray-800"></div>
                        )}
                        {/* Timeline dot */}
                        <div className="absolute left-0 top-1 w-6 h-6 rounded-full bg-[#368F8B]/10 border-2 border-[#368F8B] flex items-center justify-center">
                          <div className="w-2 h-2 rounded-full bg-[#368F8B]"></div>
                        </div>
                        
                        <div className="bg-white dark:bg-gray-800/40 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm transition-all hover:shadow-md">
                          <div className="flex flex-wrap justify-between items-start gap-4 mb-3">
                            <div>
                              <div className="flex items-center gap-2">
                                <span className="font-bold text-gray-900 dark:text-gray-100">{comment.addedBy}</span>
                                <span className="text-xs text-gray-400 dark:text-gray-500">•</span>
                                <span className="text-sm text-gray-500 dark:text-gray-400">
                                  {new Date(comment.createdAt).toLocaleString("en-IN", {
                                    day: "2-digit", month: "short", year: "numeric", hour: "2-digit", minute: "2-digit"
                                  })}
                                </span>
                              </div>
                            </div>
                            <div className="flex gap-2">
                              {comment.stage && (
                                <Badge variant="outline" className="text-[10px] bg-slate-50 dark:bg-slate-800 border-slate-200">
                                  {comment.stage}
                                </Badge>
                              )}
                              <Badge className={
                                comment.status === 'Complete' ? 'bg-green-500 hover:bg-green-600 text-white' : 
                                comment.status === 'Reject' ? 'bg-red-500 hover:bg-red-600 text-white' : 
                                'bg-yellow-500 hover:bg-yellow-600 text-white'
                              }>
                                {comment.status}
                              </Badge>
                            </div>
                          </div>
                          
                          <p className="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-wrap leading-relaxed">
                            {comment.comment}
                          </p>
                          
                          {comment.fileUrl && (
                            <div className="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800">
                              <a
                                href={comment.fileUrl.startsWith("/") ? `${API_BASE_URL.replace("/api", "")}${comment.fileUrl}` : comment.fileUrl}
                                target="_blank"
                                rel="noreferrer"
                                className="inline-flex items-center gap-2 text-sm font-semibold text-[#368F8B] hover:text-[#2d7a76] hover:underline bg-[#368F8B]/5 px-3 py-1.5 rounded-lg transition-colors"
                              >
                                <FileImage className="w-4 h-4" />
                                {comment.fileName || "View Attachment"}
                              </a>
                            </div>
                          )}
                        </div>
                      </div>
                    ))}
                  </div>
                )}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Add Remark Modal */}
      <Dialog open={isModalOpen} onOpenChange={setIsModalOpen}>
        <DialogContent className="sm:max-w-[550px] dark:bg-[#1a1c1e] dark:border-gray-800 p-0 overflow-hidden">
          <div className="bg-[#368F8B] px-6 py-4 flex items-center justify-between">
            <DialogTitle className="text-xl font-bold text-white flex items-center gap-2 m-0">
              <MessageSquare className="w-5 h-5" />
              Add Follow-up Remark
            </DialogTitle>
          </div>
          
          <form onSubmit={handleAddRemark} className="p-6 space-y-5">
            <div className="grid grid-cols-2 gap-4">
              <div className="space-y-2">
                <Label htmlFor="status" className="text-gray-700 dark:text-gray-300 font-semibold">Update Status</Label>
                <Select
                  value={remarkStatus || issue.status}
                  onValueChange={setRemarkStatus}
                >
                  <SelectTrigger className="w-full bg-white dark:bg-[#202123] border-gray-200 dark:border-gray-700">
                    <SelectValue placeholder="Select Status" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="Pending">Pending</SelectItem>
                    <SelectItem value="Incomplete">Incomplete</SelectItem>
                    <SelectItem value="In Progress">In Progress</SelectItem>
                    <SelectItem value="Complete">Complete</SelectItem>
                    <SelectItem value="Reject">Reject</SelectItem>
                  </SelectContent>
                </Select>
              </div>

              <div className="space-y-2">
                <Label htmlFor="stage" className="text-gray-700 dark:text-gray-300 font-semibold flex justify-between">
                  Promote/Transfer Level 
                </Label>
                <Select
                  value={remarkStage || issue.issueType}
                  onValueChange={setRemarkStage}
                >
                  <SelectTrigger className="w-full bg-white dark:bg-[#202123] border-gray-200 dark:border-gray-700">
                    <SelectValue placeholder="Select Level" />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value="assembly-issue">Assembly Issue (General)</SelectItem>
                    <SelectItem value="block-level">Block Level</SelectItem>
                    <SelectItem value="bhopal-level">Bhopal Level</SelectItem>
                    <SelectItem value="uss-level">USS Level</SelectItem>
                  </SelectContent>
                </Select>
                <p className="text-[10px] text-gray-500 mt-1">Updates where this issue appears.</p>
              </div>
            </div>

            <div className="space-y-2">
              <Label htmlFor="comment" className="text-gray-700 dark:text-gray-300 font-semibold">Remark / Comment <span className="text-red-500">*</span></Label>
              <Textarea
                id="comment"
                value={remarkText}
                onChange={(e) => setRemarkText(e.target.value)}
                placeholder="Enter details about the follow-up or status update..."
                className="min-h-[120px] bg-white dark:bg-[#202123] border-gray-200 dark:border-gray-700 resize-y"
                required
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor="file" className="text-gray-700 dark:text-gray-300 font-semibold">Attachment (Optional)</Label>
              <div className="flex items-center gap-3">
                <div className="relative flex-1">
                  <Input
                    id="file"
                    type="file"
                    onChange={(e) => setRemarkFile(e.target.files?.[0] || null)}
                    className="pl-10 bg-white dark:bg-[#202123] border-gray-200 dark:border-gray-700 cursor-pointer file:cursor-pointer file:border-0 file:bg-transparent file:text-sm file:font-medium"
                  />
                  <Upload className="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" />
                </div>
                {remarkFile && (
                  <Button 
                    type="button" 
                    variant="ghost" 
                    onClick={() => setRemarkFile(null)}
                    className="text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 px-3"
                  >
                    Clear
                  </Button>
                )}
              </div>
            </div>

            <div className="pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-800">
              <Button
                type="button"
                variant="outline"
                onClick={() => setIsModalOpen(false)}
                className="border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300"
              >
                Cancel
              </Button>
              <Button
                type="submit"
                disabled={submitting || !remarkText.trim()}
                className="bg-[#368F8B] hover:bg-[#2d7a76] text-white font-bold px-6 shadow-md shadow-[#368F8B]/20"
              >
                {submitting ? (
                  <div className="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin mr-2"></div>
                ) : (
                  <Plus className="w-4 h-4 mr-2" />
                )}
                Save Remark
              </Button>
            </div>
          </form>
        </DialogContent>
      </Dialog>
    </>
  );
};

export default ViewAssemblyIssue;
