"use client";

import { useState, useEffect } from "react";
import { useRouter } from "@app/hooks/useCustomRouter";

import { useFormik } from "formik";
import * as Yup from "yup";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";

import { ContentHeader } from "@app/components";
import { RouteGuard } from "@app/components/RouteGuard";
import { PERMISSIONS } from "@app/config/permissions";
import { Button } from "@app/components/ui/button";
import { Input } from "@app/components/ui/input";
import { Label } from "@app/components/ui/label";
import { Textarea } from "@app/components/ui/textarea";
import { Checkbox } from "@app/components/ui/checkbox";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { Loader2 } from "lucide-react";

const ADDITIONAL_CODE_OPTIONS = [
  "BG", "BC", "ER", "BR", "IP", "SC", "SA", "YC", "AP", "FP", "PP", "WC", "PA", "PC", "AK", "FM", "ZP", "VP", "SR", "IN", "EO", "GS", "US", "PW", "NL", "FR", "SO", "ST", "OB", "SMW", "SMTW", "IT", "TEST", "DYC", "DCC", "OBC", "CELL/MP", "DT", "DP", "AVP", "MEET", "MEDIA", "MLA,X MLA", "VECH", "IT CELL EXP", "INFO", "NSUI", "IMP", "ADVISE", "REF"
];

const validationSchema = Yup.object().shape({
  name: Yup.string().required("Name is required"),
});

const MPVidhansabhaMemberForm = () => {
  const router = useRouter();
  const [isSubmitting, setIsSubmitting] = useState(false);

  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [villagesList, setVillagesList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);
  const [parliamentsList, setParliamentsList] = useState<any[]>([]);

  useEffect(() => {
    fetchDistricts();
    fetchVidhansabha();
    fetchParliaments();
  }, []);

  const fetchDistricts = async () => {
    try {
      const res = await axios.get("/districts?limit=-1");
      setDistrictsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching districts:", err);
      setDistrictsList([
        { _id: "1", name: "Nagpur" },
        { _id: "2", name: "Wardha" },
        { _id: "3", name: "Aurangabad" },
        { _id: "4", name: "Ahmedabad" },
        { _id: "5", name: "Indore" },
        { _id: "6", name: "Jaipur" },
      ]);
    }
  };

  const fetchVidhansabha = async () => {
    try {
      const res = await axios.get("/assemblies?limit=-1");
      setVidhansabhaList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching vidhan sabha:", err);
    }
  };

  const fetchParliaments = async () => {
    try {
      const res = await axios.get("/parliaments?limit=-1");
      setParliamentsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching parliaments:", err);
    }
  };

  const fetchBlocks = async (districtId: string) => {
    try {
      const res = await axios.get(`/blocks?limit=-1&district=${districtId}`);
      setBlocksList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching blocks:", err);
      setBlocksList([
        { _id: "1", name: "Nagpur Block" },
        { _id: "2", name: "Wardha Block" },
        { _id: "3", name: "Aurangabad Block" },
        { _id: "4", name: "Ahmedabad Block" },
        { _id: "5", name: "Indore Block" },
      ]);
    }
  };

  const fetchPanchayats = async (blockId: string) => {
    try {
      const res = await axios.get(`/panchayat?limit=-1&block=${blockId}`);
      setPanchayatsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching panchayats:", err);
      setPanchayatsList([
        { _id: "1", name: "Panchayat A" },
        { _id: "2", name: "Panchayat B" },
        { _id: "3", name: "Panchayat C" },
        { _id: "4", name: "Panchayat D" },
        { _id: "5", name: "Panchayat E" },
      ]);
    }
  };

  const fetchVillages = async (panchayatId: string) => {
    try {
      const res = await axios.get(`/villages?limit=-1&panchayat=${panchayatId}`);
      setVillagesList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching villages:", err);
      setVillagesList([
        { _id: "1", name: "Village A" },
        { _id: "2", name: "Village B" },
        { _id: "3", name: "Village C" },
        { _id: "4", name: "Village D" },
        { _id: "5", name: "Village E" },
      ]);
    }
  };

  const formik = useFormik({
    initialValues: {
      month: "",
      date: "",
      district: "",
      vidhansabha: "",
      block: "",
      panchayat: "",
      village: "",
      name: "",
      position: "",
      mobile: "",
      lokSabha: "",
      year: "",
      code: "",
      remark: "",
    },
    validationSchema,
    onSubmit: async (values) => {
      try {
        setIsSubmitting(true);
        
        // Prepare data with memberType
        const dataToSubmit = {
          ...values,
          memberType: "mp-vidhan-sabha", // Explicitly set memberType
        };
        
        console.log("Submitting data:", dataToSubmit);
        
        const response = await axios.post("/members", dataToSubmit);
        console.log("Response:", response.data);
        
        toast.success("MP Vidhan Sabha Member created successfully");
        router.push("/mp-vidhan-sabha-members");
      } catch (error: any) {
        console.error("Error:", error.response?.data || error.message);
        toast.error(error.response?.data?.message || "Failed to create member");
      } finally {
        setIsSubmitting(false);
      }
    },
  });

  const handleCheckboxChange = (field: "code", value: string, checked: boolean) => {
    const currentValues = (formik.values[field] ? formik.values[field].split(",") : []).filter((v) => v !== "");
    if (checked) {
      formik.setFieldValue(field, [...currentValues, value].join(","));
    } else {
      formik.setFieldValue(field, currentValues.filter((v) => v !== value).join(","));
    }
  };

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.CREATE_MEMBERS]}>
      <ContentHeader title="Add MP Vidhan Sabha Member" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 mx-auto mt-6">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
              MP Vidhan Sabha Member Form
            </h2>
            <form onSubmit={formik.handleSubmit} className="space-y-6 text-sm">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                {/* Month */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Month</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("month", val)}
                    value={formik.values.month}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Month" />
                    </SelectTrigger>
                    <SelectContent>
                      {["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"].map(m => (
                        <SelectItem key={m} value={m}>{m}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>
                
                {/* Date */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Date</Label>
                  <Input type="date" name="date" value={formik.values.date} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>

                {/* District */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">District</Label>
                  <Select
                    onValueChange={(val) => {
                      const dist = districtsList.find((d) => d.name === val);
                      formik.setFieldValue("district", val);
                      if (dist?._id) fetchBlocks(dist._id);
                    }}
                    value={formik.values.district}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select District" />
                    </SelectTrigger>
                    <SelectContent>
                      {districtsList.map((d) => (
                        <SelectItem key={d._id} value={d.name}>{d.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Vidhansabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Vidhansabha</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("vidhansabha", val)}
                    value={formik.values.vidhansabha}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Vidhansabha" />
                    </SelectTrigger>
                    <SelectContent>
                      {vidhansabhaList.map((vs) => (
                        <SelectItem key={vs._id} value={vs.name}>{vs.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Block */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Block</Label>
                  <Select
                    onValueChange={(val) => {
                      const block = blocksList.find((b) => b.name === val);
                      formik.setFieldValue("block", val);
                      if (block?._id) fetchPanchayats(block._id);
                    }}
                    value={formik.values.block}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Block" />
                    </SelectTrigger>
                    <SelectContent>
                      {blocksList.map((b) => (
                        <SelectItem key={b._id} value={b.name}>{b.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Panchayat */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Panchayat</Label>
                  <Select
                    onValueChange={(val) => {
                      const gp = panchayatsList.find((p) => p.name === val);
                      formik.setFieldValue("panchayat", val);
                      if (gp?._id) fetchVillages(gp._id);
                    }}
                    value={formik.values.panchayat}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Panchayat" />
                    </SelectTrigger>
                    <SelectContent>
                      {panchayatsList.map((p) => (
                        <SelectItem key={p._id} value={p.name}>{p.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Village */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Village</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("village", val)}
                    value={formik.values.village}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Village" />
                    </SelectTrigger>
                    <SelectContent>
                      {villagesList.map((v) => (
                        <SelectItem key={v._id} value={v.name}>{v.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Name <span className="text-red-500">*</span></Label>
                  <Input name="name" value={formik.values.name} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter name" />
                  {formik.errors.name && formik.touched.name && (
                    <p className="text-red-500 text-sm mt-1">{formik.errors.name}</p>
                  )}
                </div>

                {/* Position */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Position</Label>
                  <Input name="position" value={formik.values.position} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter position" />
                </div>
                
                {/* Mobile */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Mobile No</Label>
                  <Input name="mobile" value={formik.values.mobile} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Mobile No" />
                </div>
                
                {/* Lok Sabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Lok Sabha</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("lokSabha", val)}
                    value={formik.values.lokSabha}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Lok Sabha" />
                    </SelectTrigger>
                    <SelectContent>
                      {parliamentsList.map((p) => (
                        <SelectItem key={p._id} value={p.name}>{p.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>
                
                {/* Year */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Year</Label>
                  <Input name="year" value={formik.values.year} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Year" />
                </div>
              </div>

              {/* Code Section */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <Label className="font-bold text-gray-700 dark:text-gray-200 text-lg mb-4 block">Additional Code</Label>
                <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-y-3 gap-x-2">
                  {ADDITIONAL_CODE_OPTIONS.map((opt) => (
                    <div key={opt} className="flex items-center space-x-2">
                      <Checkbox
                        id={`acode-${opt}`}
                        checked={(formik.values.code || "").split(",").includes(opt)}
                        onCheckedChange={(checked) => handleCheckboxChange("code", opt, !!checked)}
                      />
                      <label htmlFor={`acode-${opt}`} className="text-xs font-medium leading-none cursor-pointer dark:text-gray-400">
                        {opt}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              {/* Remark */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Remark</Label>
                  <Textarea name="remark" value={formik.values.remark} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" rows={4} placeholder="Enter remark" />
                </div>
              </div>
              
              {/* Buttons */}
              <div className="flex items-center justify-end gap-4 pt-4">
                <Button type="button" variant="outline" onClick={() => router.back()} className="w-24">
                  Cancel
                </Button>
                <Button type="submit" disabled={isSubmitting} className="bg-[#368F8B] hover:bg-[#2d7a76] min-w-32">
                  {isSubmitting ? (
                    <div className="flex items-center">
                      <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                      Submitting
                    </div>
                  ) : (
                    "Submit"
                  )}
                </Button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </RouteGuard>
  );
};

export default MPVidhansabhaMemberForm;
