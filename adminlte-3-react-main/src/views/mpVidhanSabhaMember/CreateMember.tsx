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

const ADDITIONAL_CODES = [
  { key: "bg", label: "BG" }, { key: "bc", label: "BC" }, { key: "er", label: "ER" },
  { key: "br", label: "BR" }, { key: "ip", label: "IP" }, { key: "sc", label: "SC" },
  { key: "sa", label: "SA" }, { key: "yc", label: "YC" }, { key: "ap", label: "AP" },
  { key: "fp", label: "FP" }, { key: "pp", label: "PP" }, { key: "wc", label: "WC" },
  { key: "pa", label: "PA" }, { key: "pc", label: "PC" }, { key: "ak", label: "AK" },
  { key: "fm", label: "FM" }, { key: "zp", label: "ZP" }, { key: "vp", label: "VP" },
  { key: "sr", label: "SR" }, { key: "in_field", label: "IN" }, { key: "eo", label: "EO" },
  { key: "gs", label: "GS" }, { key: "us", label: "US" }, { key: "pw", label: "PW" },
  { key: "nl", label: "NL" }, { key: "fr", label: "FR" }, { key: "so", label: "SO" },
  { key: "st", label: "ST" }, { key: "ob", label: "OB" }, { key: "smw", label: "SMW" },
  { key: "smtw", label: "SMTW" }, { key: "it", label: "IT" }, { key: "test", label: "TEST" },
  { key: "dyc", label: "DYC" }, { key: "dcc", label: "DCC" }, { key: "obc", label: "OBC" },
  { key: "cell_mp", label: "CELL/MP" }, { key: "dt", label: "DT" }, { key: "dp", label: "DP" },
  { key: "avp", label: "AVP" }, { key: "meet", label: "MEET" }, { key: "media", label: "MEDIA" },
  { key: "mla_x_mla", label: "MLA,X MLA" }, { key: "vech", label: "VECH" },
  { key: "it_cell_exp", label: "IT CELL EXP" }, { key: "info", label: "INFO" },
  { key: "nsui", label: "NSUI" }, { key: "imp", label: "IMP" }, { key: "advise", label: "ADVISE" },
  { key: "ref_code", label: "REF" },
];

const validationSchema = Yup.object().shape({});

const CreateMember = () => {
  const router = useRouter();
  const [isSubmitting, setIsSubmitting] = useState(false);

  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [villagesList, setVillagesList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);

  useEffect(() => {
    fetchDistricts();
    fetchVidhansabha();
  }, []);

  const fetchDistricts = async () => {
    try {
      const res = await axios.get("/districts?limit=-1");
      setDistrictsList(res.data?.data || []);
    } catch (err) {}
  };

  const fetchVidhansabha = async () => {
    try {
      const res = await axios.get("/assemblies?limit=-1");
      setVidhansabhaList(res.data?.data || []);
    } catch (err) {}
  };

  const fetchBlocks = async (districtId: string) => {
    try {
      const res = await axios.get(`/blocks?limit=-1&district=${districtId}`);
      setBlocksList(res.data?.data || []);
    } catch (err) {}
  };

  const fetchPanchayats = async (blockId: string) => {
    try {
      const res = await axios.get(`/panchayat?limit=-1&block=${blockId}`);
      setPanchayatsList(res.data?.data || []);
    } catch (err) {}
  };

  const fetchVillages = async (panchayatId: string) => {
    try {
      const res = await axios.get(`/villages?limit=-1&panchayat=${panchayatId}`);
      setVillagesList(res.data?.data || []);
    } catch (err) {}
  };

  const formik = useFormik({
    initialValues: {
      month: "",
      date: "",
      district: "",
      vidhansabha: "",
      block: "",
      grampanchayat: "",
      village: "",
      name: "",
      position: "",
      mobile: "",
      lokSabha: "",
      year: "",
      remark: "",
      // Additional Code Boolean Flags
      bg: false, bc: false, er: false, br: false, ip: false, sc: false, sa: false, yc: false,
      ap: false, fp: false, pp: false, wc: false, pa: false, pc: false, ak: false, fm: false,
      zp: false, vp: false, sr: false, in_field: false, eo: false, gs: false, us: false,
      pw: false, nl: false, fr: false, so: false, st: false, ob: false, smw: false, smtw: false,
      it: false, test: false, dyc: false, dcc: false, obc: false, cell_mp: false, dt: false,
      dp: false, avp: false, meet: false, media: false, mla_x_mla: false, vech: false,
      it_cell_exp: false, info: false, nsui: false, imp: false, advise: false, ref_code: false,
    },
    validationSchema,
    onSubmit: async (values) => {
      try {
        setIsSubmitting(true);
        const sanitizedValues = Object.keys(values).reduce((acc, key) => {
          acc[key] = (values as any)[key] === undefined ? "" : (values as any)[key];
          return acc;
        }, {} as any);

        const payload = { ...sanitizedValues, memberType: "vidhan-sabha" };

        await axios.post("/mp-vidhan-sabha-members", payload);
        toast.success("Member added successfully!");
        router.push("/mp-vidhan-sabha-member");
      } catch (error: any) {
        toast.error(error.response?.data?.message || "Failed to submit form");
      } finally {
        setIsSubmitting(false);
      }
    },
  });

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.CREATE_MEMBERS]}>
      <ContentHeader title="Add MP Vidhan Sabha Member" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 mx-auto mt-6">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
              Survey Form
            </h2>
            <form onSubmit={formik.handleSubmit} className="space-y-6 text-sm">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                {/* Month */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Month</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("month", val)} value={formik.values.month}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Month" />
                    </SelectTrigger>
                    <SelectContent>
                      {["January","February","March","April","May","June","July","August","September","October","November","December"].map((m) => (
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
                      const dist = districtsList.find((d) => d.name === val || d._id === val);
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

                {/* Vidhan Sabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Vidhan Sabha</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("vidhansabha", val)}
                    value={formik.values.vidhansabha}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Vidhan Sabha" />
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
                      const block = blocksList.find((b) => b.name === val || b._id === val);
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

                {/* Gram Panchayat */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Gram Panchayat</Label>
                  <Select
                    onValueChange={(val) => {
                      const gp = panchayatsList.find((p) => p.name === val || p._id === val);
                      formik.setFieldValue("grampanchayat", val);
                      if (gp?._id) fetchVillages(gp._id);
                    }}
                    value={formik.values.grampanchayat}
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
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Name</Label>
                  <Input name="name" value={formik.values.name} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Name" />
                </div>

                {/* Position */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Position</Label>
                  <Input name="position" value={formik.values.position} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Position" />
                </div>

                {/* Mobile */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Mobile No</Label>
                  <Input name="mobile" maxLength={10} value={formik.values.mobile} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Mobile No" />
                </div>

                {/* Lok Sabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Lok Sabha</Label>
                  <Input name="lokSabha" value={formik.values.lokSabha} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Lok Sabha" />
                </div>

                {/* Year */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Year</Label>
                  <Input name="year" value={formik.values.year} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Year" />
                </div>

                {/* Remark */}
                <div className="space-y-1.5 col-span-1 md:col-span-2 xl:col-span-4">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Remark</Label>
                  <Textarea name="remark" value={formik.values.remark} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" rows={3} placeholder="Enter Remark" />
                </div>
              </div>

              {/* Additional Code Section */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <h3 className="font-bold text-gray-800 dark:text-gray-100 text-lg mb-4">Additional Code</h3>
                <div className="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                  {ADDITIONAL_CODES.map((code) => (
                    <div key={code.key} className="flex items-center space-x-2">
                      <Checkbox
                        id={`addcode-${code.key}`}
                        name={code.key}
                        checked={(formik.values as any)[code.key]}
                        onCheckedChange={(checked) => formik.setFieldValue(code.key, !!checked)}
                        className="h-4 w-4 rounded border-gray-300 text-[#368F8B] focus:ring-[#368F8B] dark:border-gray-700 dark:bg-gray-800 cursor-pointer"
                      />
                      <label htmlFor={`addcode-${code.key}`} className="text-sm font-medium leading-none cursor-pointer dark:text-gray-400">
                        {code.label}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              <div className="flex items-center gap-4 pt-4">
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
                <Button type="button" variant="outline" onClick={() => router.back()}>
                  Cancel
                </Button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </RouteGuard>
  );
};

export default CreateMember;
