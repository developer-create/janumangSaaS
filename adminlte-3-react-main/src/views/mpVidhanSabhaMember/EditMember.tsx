"use client";

import { useState, useEffect } from "react";
import { useRouter } from "@app/hooks/useCustomRouter";
import { useParams } from "next/navigation";
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

const EditMember = () => {
  const router = useRouter();
  const { id } = useParams();
  const [loading, setLoading] = useState(true);
  const [isSubmitting, setIsSubmitting] = useState(false);

  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [villagesList, setVillagesList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);

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
        const payload = { ...values, memberType: "vidhan-sabha" };
        await axios.put(`/mp-vidhan-sabha-members/${id}`, payload);
        toast.success("Member updated successfully");
        router.push("/mp-vidhan-sabha-member");
      } catch (error: any) {
        toast.error(error.response?.data?.message || "Failed to update member");
      } finally {
        setIsSubmitting(false);
      }
    },
  });

  useEffect(() => {
    fetchInitialData();
  }, []);

  // ── Fetch helpers — each returns the loaded list so callers can use it immediately ──

  const fetchDistricts = async (): Promise<any[]> => {
    try {
      const res = await axios.get("/districts?limit=-1");
      const list = res.data?.data || [];
      setDistrictsList(list);
      return list;
    } catch { return []; }
  };

  const fetchVidhansabha = async (): Promise<any[]> => {
    try {
      const res = await axios.get("/assemblies?limit=-1");
      const list = res.data?.data || [];
      setVidhansabhaList(list);
      return list;
    } catch { return []; }
  };

  // Fetch blocks by district — accepts district name or _id
  const fetchBlocks = async (districtNameOrId: string): Promise<any[]> => {
    try {
      // First try direct API with value (works if it's an ID)
      let res = await axios.get(`/blocks?limit=-1&district=${districtNameOrId}`);
      let list = res.data?.data || [];
      if (!list.length) {
        // Try fetching all blocks and filter by name
        res = await axios.get("/blocks?limit=-1");
        const all = res.data?.data || [];
        list = all.filter((b: any) =>
          b.district?.name === districtNameOrId ||
          b.district === districtNameOrId ||
          b.district?._id === districtNameOrId
        );
        if (!list.length) list = all;
      }
      setBlocksList(list);
      return list;
    } catch { return []; }
  };

  // Fetch panchayats by block — accepts block name or _id
  const fetchPanchayats = async (blockNameOrId: string, blocks?: any[]): Promise<any[]> => {
    try {
      const currentBlocks = blocks || blocksList;
      // Resolve to _id if needed
      let blockId = blockNameOrId;
      if (!/^[0-9a-fA-F]{24}$/.test(blockNameOrId)) {
        const found = currentBlocks.find(
          (b: any) => b.name === blockNameOrId || b._id === blockNameOrId
        );
        blockId = found?._id || blockNameOrId;
      }
      const res = await axios.get(`/panchayat?limit=-1&block=${blockId}`);
      const list = res.data?.data || [];
      setPanchayatsList(list);
      return list;
    } catch { return []; }
  };

  // Fetch villages by panchayat — accepts panchayat name or _id
  const fetchVillages = async (panchayatNameOrId: string, panchayats?: any[]): Promise<any[]> => {
    try {
      const currentPanchayats = panchayats || panchayatsList;
      let gpId = panchayatNameOrId;
      if (!/^[0-9a-fA-F]{24}$/.test(panchayatNameOrId)) {
        const found = currentPanchayats.find(
          (p: any) => p.name === panchayatNameOrId || p._id === panchayatNameOrId
        );
        gpId = found?._id || panchayatNameOrId;
      }
      const res = await axios.get(`/villages?limit=-1&panchayat=${gpId}`);
      const list = res.data?.data || [];
      setVillagesList(list);
      return list;
    } catch { return []; }
  };

  const fetchInitialData = async () => {
    try {
      setLoading(true);
      // Fetch base lists in parallel
      const [districts, vslist] = await Promise.all([fetchDistricts(), fetchVidhansabha()]);

      if (!id) return;
      const { data } = await axios.get(`/mp-vidhan-sabha-members/${id}`);
      const m = data.data;

      // Resolve district → blocks → panchayats → villages sequentially
      let loadedBlocks: any[] = [];
      let loadedPanchayats: any[] = [];

      if (m.district) {
        // Find district id
        const distObj = districts.find(
          (d: any) => d.name === m.district || d._id === m.district
        );
        const distId = distObj?._id || m.district;
        loadedBlocks = await fetchBlocks(distId);
      }

      if (m.block) {
        loadedPanchayats = await fetchPanchayats(m.block, loadedBlocks);
      }

      if (m.grampanchayat) {
        const gpValue = typeof m.grampanchayat === "object"
          ? m.grampanchayat?.name || m.grampanchayat?._id
          : m.grampanchayat;
        await fetchVillages(gpValue, loadedPanchayats);
      }

      // Set all form values
      formik.setValues({
        month: m.month || "",
        date: m.date ? m.date.split("T")[0] : "",
        district: m.district || "",
        vidhansabha: (typeof m.vidhansabha === "object" ? m.vidhansabha?.name : m.vidhansabha) || "",
        block: m.block || "",
        grampanchayat: (typeof m.grampanchayat === "object" ? m.grampanchayat?.name : m.grampanchayat) || "",
        village: (typeof m.village === "object" ? m.village?.name : m.village) || "",
        name: m.name || "",
        position: m.position || "",
        mobile: m.mobile || "",
        lokSabha: m.lokSabha || "",
        year: m.year || "",
        remark: m.remark || "",
        // Boolean flags
        bg: m.bg || false, bc: m.bc || false, er: m.er || false, br: m.br || false,
        ip: m.ip || false, sc: m.sc || false, sa: m.sa || false, yc: m.yc || false,
        ap: m.ap || false, fp: m.fp || false, pp: m.pp || false, wc: m.wc || false,
        pa: m.pa || false, pc: m.pc || false, ak: m.ak || false, fm: m.fm || false,
        zp: m.zp || false, vp: m.vp || false, sr: m.sr || false, in_field: m.in_field || false,
        eo: m.eo || false, gs: m.gs || false, us: m.us || false, pw: m.pw || false,
        nl: m.nl || false, fr: m.fr || false, so: m.so || false, st: m.st || false,
        ob: m.ob || false, smw: m.smw || false, smtw: m.smtw || false, it: m.it || false,
        test: m.test || false, dyc: m.dyc || false, dcc: m.dcc || false, obc: m.obc || false,
        cell_mp: m.cell_mp || false, dt: m.dt || false, dp: m.dp || false,
        avp: m.avp || false, meet: m.meet || false, media: m.media || false,
        mla_x_mla: m.mla_x_mla || false, vech: m.vech || false,
        it_cell_exp: m.it_cell_exp || false, info: m.info || false,
        nsui: m.nsui || false, imp: m.imp || false, advise: m.advise || false,
        ref_code: m.ref_code || false,
      });
    } catch (error) {
      toast.error("Failed to fetch member details");
    } finally {
      setLoading(false);
    }
  };

  if (loading) return <div className="p-10 text-center text-gray-500">Loading Form...</div>;

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.EDIT_MEMBERS]}>
      <ContentHeader title="Edit MP Vidhan Sabha Member" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 mx-auto mt-6">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
              Edit Survey Form
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
                      const dist = districtsList.find((d) => d.name === val);
                      formik.setFieldValue("district", val);
                      formik.setFieldValue("block", "");
                      formik.setFieldValue("grampanchayat", "");
                      formik.setFieldValue("village", "");
                      setPanchayatsList([]);
                      setVillagesList([]);
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
                      const block = blocksList.find((b) => b.name === val);
                      formik.setFieldValue("block", val);
                      formik.setFieldValue("grampanchayat", "");
                      formik.setFieldValue("village", "");
                      setVillagesList([]);
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
                      const gp = panchayatsList.find((p) => p.name === val);
                      formik.setFieldValue("grampanchayat", val);
                      formik.setFieldValue("village", "");
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
                        id={`editcode-${code.key}`}
                        name={code.key}
                        checked={(formik.values as any)[code.key]}
                        onCheckedChange={(checked) => formik.setFieldValue(code.key, !!checked)}
                        className="h-4 w-4 rounded border-gray-300 text-[#368F8B] focus:ring-[#368F8B] dark:border-gray-700 dark:bg-gray-800 cursor-pointer"
                      />
                      <label htmlFor={`editcode-${code.key}`} className="text-sm font-medium leading-none cursor-pointer dark:text-gray-400">
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
                      Saving...
                    </div>
                  ) : (
                    "Save Changes"
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

export default EditMember;
