import React, { useState } from "react";
import { useRouter } from "next/navigation";
import { ContentHeader } from "@app/components";
import { toast } from "react-toastify";
import axios from "@app/utils/axios";
import { Upload, Download, ArrowLeft, Info, FileSpreadsheet, CheckCircle2, AlertCircle } from "lucide-react";

const BulkUpload = () => {
  const router = useRouter();
  const [file, setFile] = useState<File | null>(null);
  const [uploading, setUploading] = useState(false);

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files.length > 0) {
      const selectedFile = e.target.files[0];
      const maxSize = 10 * 1024 * 1024; // 10MB
      
      if (selectedFile.size > maxSize) {
        toast.error("File size exceeds 10MB limit. Please choose a smaller file.");
        setFile(null);
        e.target.value = "";
        return;
      }
      
      if (selectedFile.type !== "text/csv" && !selectedFile.name.endsWith(".csv") && selectedFile.type !== "application/vnd.ms-excel") {
        toast.error("Please select a valid CSV file.");
        setFile(null);
        e.target.value = "";
        return;
      }
      
      setFile(selectedFile);
    }
  };

  const handleDownloadTemplate = async () => {
    try {
      const response = await axios.get("/mp-vidhan-sabha-members/template", {
        responseType: "blob",
      });
      const url = window.URL.createObjectURL(new Blob([response.data]));
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute("download", "Member_Upload_Template.csv");
      document.body.appendChild(link);
      link.click();
      link.parentNode?.removeChild(link);
    } catch (error) {
      toast.error("Failed to download template.");
    }
  };

  const handleUpload = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!file) {
      toast.error("Please select a file first.");
      return;
    }

    setUploading(true);
    const formData = new FormData();
    formData.append("bulk_file", file);

    try {
      const response = await axios.post(`/mp-vidhan-sabha-members/bulk-upload`, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      });
      
      if (response.data.success) {
        toast.success(response.data.message || "File uploaded successfully!");
        if (response.data.errors && response.data.errors.length > 0) {
          toast.warning(`${response.data.errors.length} rows had errors. Check console.`);
          console.warn("Upload Errors:", response.data.errors);
        }
        setTimeout(() => {
          router.push("/mp-vidhan-sabha-member");
        }, 1500);
      }
    } catch (error: any) {
      const msg = error.response?.data?.message || "Failed to upload file.";
      toast.error(msg);
    } finally {
      setUploading(false);
    }
  };

  return (
    <>
      <ContentHeader title="Bulk Upload MP Vidhan Sabha Members" />
      <section className="p-4 sm:p-6 lg:p-8">
        <div className="max-w-7xl mx-auto space-y-6">
          
          {/* Main Card */}
          <div className="bg-white dark:bg-[#202123] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
            
            {/* Header Section */}
            <div className="px-6 py-5 border-b border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gray-50/50 dark:bg-[#2a2b2d]/50">
              <div className="flex items-center gap-3">
                <div className="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                  <FileSpreadsheet className="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                  <h3 className="text-lg font-semibold text-gray-900 dark:text-white">Upload Member Data</h3>
                  <p className="text-sm text-gray-500 dark:text-gray-400">Add multiple members at once using a CSV file</p>
                </div>
              </div>
              
              <div className="flex items-center gap-3">
                <button 
                  onClick={() => {
                    router.push("/mp-vidhan-sabha-member");
                  }}
                  className="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-[#202123] dark:text-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 transition-colors shadow-sm"
                >
                  <ArrowLeft className="w-4 h-4 mr-2" /> Back to List
                </button>
                <button 
                  onClick={handleDownloadTemplate}
                  className="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/30 dark:hover:bg-blue-900/40 transition-colors shadow-sm"
                >
                  <Download className="w-4 h-4 mr-2" /> Get Template
                </button>
              </div>
            </div>
            
            <div className="p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
              
              {/* Form Section */}
              <div className="lg:col-span-2 space-y-6">
                <form onSubmit={handleUpload} className="space-y-6">
                  <div className="space-y-2">
                    <label htmlFor="bulk_file" className="block text-sm font-medium text-gray-700 dark:text-gray-300">
                      Select CSV File <span className="text-red-500">*</span>
                    </label>
                    <div className="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group relative cursor-pointer" onClick={() => document.getElementById('bulk_file')?.click()}>
                      <div className="space-y-2 text-center">
                        <Upload className="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition-colors" />
                        <div className="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                          <span className="relative rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                            <span>Upload a file</span>
                            <input 
                              id="bulk_file" 
                              name="bulk_file" 
                              type="file" 
                              accept=".csv" 
                              className="sr-only" 
                              required 
                              onChange={handleFileChange}
                            />
                          </span>
                          <p className="pl-1">or drag and drop</p>
                        </div>
                        <p className="text-xs text-gray-500 dark:text-gray-500">
                          CSV up to 10MB
                        </p>
                        {file && (
                          <div className="mt-4 inline-flex items-center px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-sm font-medium">
                            <CheckCircle2 className="w-4 h-4 mr-2" />
                            {file.name} ({(file.size / 1024 / 1024).toFixed(2)} MB)
                          </div>
                        )}
                      </div>
                    </div>
                  </div>

                  <div className="bg-amber-50 dark:bg-amber-900/10 border-l-4 border-amber-400 p-4 rounded-r-lg">
                    <div className="flex items-start">
                      <div className="flex-shrink-0">
                        <AlertCircle className="h-5 w-5 text-amber-400" />
                      </div>
                      <div className="ml-3">
                        <p className="text-sm text-amber-700 dark:text-amber-500">
                          <strong className="font-medium">Note:</strong> If you are using Excel, please make sure to use <strong>File &rarr; Save As</strong> and choose <strong>CSV (Comma delimited)</strong> format before uploading.
                        </p>
                      </div>
                    </div>
                  </div>
                  
                  <button 
                    type="submit" 
                    disabled={!file || uploading}
                    className="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-[#368F8B] hover:bg-[#2d7a76] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#368F8B] disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                  >
                    {uploading ? (
                      <>
                        <svg className="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading & Processing...
                      </>
                    ) : (
                      <>
                        <Upload className="w-5 h-5 mr-2" />
                        Upload & Process
                      </>
                    )}
                  </button>
                </form>
              </div>
              
              {/* Instructions Sidebar */}
              <div className="space-y-6">
                <div className="bg-gray-50 dark:bg-[#2a2b2d]/50 rounded-xl p-5 border border-gray-200 dark:border-gray-800">
                  <h4 className="flex items-center text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">
                    <Info className="w-4 h-4 mr-2 text-blue-500" />
                    How to Upload
                  </h4>
                  <ol className="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                    <li className="flex gap-3">
                      <span className="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold text-xs">1</span>
                      <span>Download the template CSV file using the button above.</span>
                    </li>
                    <li className="flex gap-3">
                      <span className="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold text-xs">2</span>
                      <span>Open in Excel/Numbers, fill in your member data according to the columns.</span>
                    </li>
                    <li className="flex gap-3">
                      <span className="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold text-xs">3</span>
                      <span>Save as CSV format and upload it here.</span>
                    </li>
                    <li className="flex gap-3">
                      <span className="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold text-xs">4</span>
                      <span>Review the results and check for any errors.</span>
                    </li>
                  </ol>
                </div>

                <div className="bg-white dark:bg-[#202123] rounded-xl p-5 border border-gray-200 dark:border-gray-800 shadow-sm">
                  <h4 className="text-sm font-semibold text-gray-900 dark:text-white mb-3">Format Guidelines</h4>
                  <ul className="space-y-2 text-sm text-gray-600 dark:text-gray-400 list-disc list-inside marker:text-gray-400">
                    <li><strong className="text-gray-900 dark:text-gray-300">Name</strong> is required for all rows.</li>
                    <li><strong className="text-gray-900 dark:text-gray-300">Dates</strong> must be <code className="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-xs">YYYY-MM-DD</code>.</li>
                    <li><strong className="text-gray-900 dark:text-gray-300">Mobile</strong> should be 10 digits only.</li>
                    <li><strong className="text-gray-900 dark:text-gray-300">Flags</strong> (bg, bc, er) use <code className="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 text-xs text-green-600">1/Yes</code> or leave empty.</li>
                    <li><strong className="text-gray-900 dark:text-gray-300">References</strong> (District, Block) use exact names, not IDs.</li>
                  </ul>
                </div>
              </div>
              
            </div>
          </div>
          
        </div>
      </section>
    </>
  );
};

export default BulkUpload;
