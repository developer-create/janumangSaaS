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
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { Loader2 } from "lucide-react";

const CODE_FIELDS = [
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
  { key: "ref", label: "REF" }
];

const validationSchema = Yup.object().shape({
  name: Yup.string().required("Name is required"),
});

const EditMPVidhansabhaMember = () => {
  const router = useRouter();
  const { id } = useParams();
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [loading, setLoading] = useState(true);

  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);

  const formik = useFormik({
    initialValues: {
      month: "",
      date: "",
      district_id: "",
      vidhan_sabha_id: "",
      block_id: "",
      panchayat_id: "",
      name: "",
      position: "",
      mobile_no: "",
      locksabha: "",
      year: "",
      remark: "",
      // 45 Boolean Code Fields
      bg: false, bc: false, er: false, br: false, ip: false, sc: false, sa: false, yc: false,
      ap: false, fp: false, pp: false, wc: false, pa: false, pc: false, ak: false, fm: false,
      zp: false, vp: false, sr: false, in_field: false, eo: false, gs: false, us: false,
      pw: false, nl: false, fr: false, so: false, st: false, ob: false, smw: false, smtw: false,
      it: false, test: false, dyc: false, dcc: false, obc: false, cell_mp: false, dt: false,
      dp: false, avp: false, meet: false, media: false, mla_x_mla: false, vech: false,
      it_cell_exp: false, info: false, nsui: false, imp: false, advise: false, ref: false,
    },
    validationSchema,
    onSubmit: async (values) => {
      try {
        setIsSubmitting(true);
        
        // Map form field names to API field names
        const dataToSubmit = {
          month: values.month,
          date: values.date,
          district: districtsList.find((d: any) => d._id === values.district_id)?.name || "",
          district_id: values.district_id,
          vidhansabha: vidhansabhaList.find((v: any) => v._id === values.vidhan_sabha_id)?.name || "",
          vidhan_sabha_id: values.vidhan_sabha_id,
          block: blocksList.find((b: any) => b._id === values.block_id)?.name || "",
          block_id: values.block_id,
          panchayat: panchayatsList.find((p: any) => p._id === values.panchayat_id)?.name || "",
          panchayat_id: values.panchayat_id,
          name: values.name,
          position: values.position,
          mobile_no: values.mobile_no,
          mobile: values.mobile_no,
          locksabha: values.locksabha,
          lokSabha: values.locksabha,
          year: values.year,
          remark: values.remark,
          memberType: "mp-vidhan-sabha",
          // Code fields
          bg: values.bg, bc: values.bc, er: values.er, br: values.br, ip: values.ip,
          sc: values.sc, sa: values.sa, yc: values.yc, ap: values.ap, fp: values.fp,
          pp: values.pp, wc: values.wc, pa: values.pa, pc: values.pc, ak: values.ak,
          fm: values.fm, zp: values.zp, vp: values.vp, sr: values.sr, in_field: values.in_field,
          eo: values.eo, gs: values.gs, us: values.us, pw: values.pw, nl: values.nl,
          fr: values.fr, so: values.so, st: values.st, ob: values.ob, smw: values.smw,
          smtw: values.smtw, it: values.it, test: values.test, dyc: values.dyc, dcc: values.dcc,
          obc: values.obc, cell_mp: values.cell_mp, dt: values.dt, dp: values.dp, avp: values.avp,
          meet: values.meet, media: values.media, mla_x_mla: values.mla_x_mla, vech: values.vech,
          it_cell_exp: values.it_cell_exp, info: values.info, nsui: values.nsui, imp: values.imp,
          advise: values.advise, ref: values.ref,
        };
        
        console.log("Updating data:", dataToSubmit);
        
        const response = await axios.put(`/members/${id}`, dataToSubmit);
        console.log("Response:", response.data);
        
        toast.success("MP Vidhan Sabha Member updated successfully");
        router.push("/mp-vidhan-sabha-members");
      } catch (error: any) {
        console.error("Error:", error.response?.data || error.message);
        toast.error(error.response?.data?.message || "Failed to update member");
      } finally {
        setIsSubmitting(false);
      }
    },
  });

  useEffect(() => {
    fetchInitialData();
  }, []);

  const fetchDistricts = async () => {
    try {
      const res = await axios.get("/districts?limit=-1");
      return res.data?.data || [];
    } catch (err) {
      console.error("Error fetching districts:", err);
      return [];
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

  const fetchBlocks = async (districtId: string) => {
    try {
      const res = await axios.get(`/blocks?limit=-1&district=${districtId}`);
      setBlocksList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching blocks:", err);
    }
  };

  const fetchPanchayats = async (blockId: string) => {
    try {
      const res = await axios.get(`/panchayat?limit=-1&block=${blockId}`);
      setPanchayatsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching panchayats:", err);
    }
  };

  const fetchInitialData = async () => {
    try {
      setLoading(true);

      // Fetch all lists
      const districts = await fetchDistricts();
      setDistrictsList(districts);
      const vidhansabhas = await (async () => {
        try {
          const res = await axios.get("/assemblies?limit=-1");
          return res.data?.data || [];
        } catch (err) {
          return [];
        }
      })();
      setVidhansabhaList(vidhansabhas);

      // Fetch member data
      const { data: memberResponse } = await axios.get(`/members/${id}`);
      const memberData = memberResponse.data;

      console.log("Member data:", memberData);

      // Extract IDs and names from member data
      let districtId = memberData.district_id;
      let blockId = memberData.block_id;
      let panchayatId = memberData.panchayat_id;
      let vidhansabhaId = memberData.vidhan_sabha_id;

      // If we don't have IDs but have names, find them
      if (!districtId && memberData.district) {
        const dist = districts.find((d: any) => d.name === memberData.district || d._id === memberData.district);
        districtId = dist?._id;
      }
      
      if (!vidhansabhaId && memberData.vidhansabha) {
        const vs = vidhansabhas.find((v: any) => v.name === memberData.vidhansabha || v._id === memberData.vidhansabha);
        vidhansabhaId = vs?._id;
      }

      console.log("IDs after lookup:", { districtId, vidhansabhaId, blockId, panchayatId });
      console.log("Names from API:", { block: memberData.block, panchayat: memberData.panchayat });

      // Fetch blocks based on district
      let blocksForDistrict = [];
      if (districtId) {
        console.log("Fetching blocks for district:", districtId);
        const res = await axios.get(`/blocks?limit=-1&district=${districtId}`);
        blocksForDistrict = res.data?.data || [];
        setBlocksList(blocksForDistrict);
      }

      // If we still don't have blockId but have block name, find it
      if (!blockId && memberData.block && blocksForDistrict.length > 0) {
        const block = blocksForDistrict.find((b: any) => b.name === memberData.block || b._id === memberData.block);
        blockId = block?._id;
        console.log("Found blockId from name:", blockId, "Available blocks:", blocksForDistrict.map((b: any) => b.name));
      }

      // Fetch panchayats based on block - THIS IS CRITICAL
      let panchayatsForBlock = [];
      if (blockId) {
        console.log("Fetching panchayats for block:", blockId);
        try {
          const res = await axios.get(`/panchayat?limit=-1&block=${blockId}`);
          panchayatsForBlock = res.data?.data || [];
          console.log("Fetched panchayats:", panchayatsForBlock);
          setPanchayatsList(panchayatsForBlock);
        } catch (err) {
          console.error("Error fetching panchayats:", err);
        }
        
        // If we still don't have panchayatId but have panchayat name, find it
        if (!panchayatId && memberData.panchayat && panchayatsForBlock.length > 0) {
          const panchayat = panchayatsForBlock.find((p: any) => p.name === memberData.panchayat || p._id === memberData.panchayat);
          panchayatId = panchayat?._id;
          console.log("Found panchayatId from name:", panchayatId, "Available panchayats:", panchayatsForBlock.map((p: any) => p.name));
        }
      }

      console.log("Final IDs:", { districtId, vidhansabhaId, blockId, panchayatId });

      // Set form values
      formik.setValues({
        month: memberData.month || "",
        date: memberData.date ? memberData.date.split("T")[0] : "",
        district_id: districtId || "",
        vidhan_sabha_id: vidhansabhaId || "",
        block_id: blockId || "",
        panchayat_id: panchayatId || "",
        name: memberData.name || "",
        position: memberData.position || "",
        mobile_no: memberData.mobile_no || memberData.mobile || "",
        locksabha: memberData.locksabha || memberData.lokSabha || "",
        year: memberData.year || "",
        remark: memberData.remark || "",
        // Code fields
        bg: memberData.bg || false,
        bc: memberData.bc || false,
        er: memberData.er || false,
        br: memberData.br || false,
        ip: memberData.ip || false,
        sc: memberData.sc || false,
        sa: memberData.sa || false,
        yc: memberData.yc || false,
        ap: memberData.ap || false,
        fp: memberData.fp || false,
        pp: memberData.pp || false,
        wc: memberData.wc || false,
        pa: memberData.pa || false,
        pc: memberData.pc || false,
        ak: memberData.ak || false,
        fm: memberData.fm || false,
        zp: memberData.zp || false,
        vp: memberData.vp || false,
        sr: memberData.sr || false,
        in_field: memberData.in_field || false,
        eo: memberData.eo || false,
        gs: memberData.gs || false,
        us: memberData.us || false,
        pw: memberData.pw || false,
        nl: memberData.nl || false,
        fr: memberData.fr || false,
        so: memberData.so || false,
        st: memberData.st || false,
        ob: memberData.ob || false,
        smw: memberData.smw || false,
        smtw: memberData.smtw || false,
        it: memberData.it || false,
        test: memberData.test || false,
        dyc: memberData.dyc || false,
        dcc: memberData.dcc || false,
        obc: memberData.obc || false,
        cell_mp: memberData.cell_mp || false,
        dt: memberData.dt || false,
        dp: memberData.dp || false,
        avp: memberData.avp || false,
        meet: memberData.meet || false,
        media: memberData.media || false,
        mla_x_mla: memberData.mla_x_mla || false,
        vech: memberData.vech || false,
        it_cell_exp: memberData.it_cell_exp || false,
        info: memberData.info || false,
        nsui: memberData.nsui || false,
        imp: memberData.imp || false,
        advise: memberData.advise || false,
        ref: memberData.ref || memberData.ref_code || false,
      });
    } catch (error) {
      console.error("Error fetching data:", error);
      toast.error("Failed to load member data");
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="p-10 text-center text-gray-500">
        Loading Member Data...
      </div>
    );
  }

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.EDIT_MEMBERS]}>
      <ContentHeader title="Edit MP Vidhan Sabha Member" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 mx-auto mt-6">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
              Edit MP Vidhan Sabha Member
            </h2>
            <form onSubmit={formik.handleSubmit} className="space-y-6 text-sm">
              {/* Main Fields Grid */}
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
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
                      formik.setFieldValue("district_id", val);
                      if (val) fetchBlocks(val);
                    }}
                    value={formik.values.district_id || ""}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select District" />
                    </SelectTrigger>
                    <SelectContent>
                      {districtsList.map((d) => (
                        <SelectItem key={d._id} value={d._id}>{d.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Vidhan Sabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Vidhan Sabha</Label>
                  <Select
                    onValueChange={(val) => {
                      formik.setFieldValue("vidhan_sabha_id", val);
                    }}
                    value={formik.values.vidhan_sabha_id || ""}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Vidhan Sabha" />
                    </SelectTrigger>
                    <SelectContent>
                      {vidhansabhaList.map((vs) => (
                        <SelectItem key={vs._id} value={vs._id}>{vs.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Block */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Block</Label>
                  <Select
                    onValueChange={(val) => {
                      formik.setFieldValue("block_id", val);
                      if (val) fetchPanchayats(val);
                    }}
                    value={formik.values.block_id || ""}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Block" />
                    </SelectTrigger>
                    <SelectContent>
                      {blocksList.map((b) => (
                        <SelectItem key={b._id} value={b._id}>{b.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Panchayat */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Panchayat</Label>
                  <Select
                    onValueChange={(val) => {
                      formik.setFieldValue("panchayat_id", val);
                    }}
                    value={formik.values.panchayat_id || ""}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Panchayat" />
                    </SelectTrigger>
                    <SelectContent>
                      {panchayatsList.map((p) => (
                        <SelectItem key={p._id} value={p._id}>{p.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Name - Required */}
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
                
                {/* Mobile No */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Mobile No</Label>
                  <Input name="mobile_no" value={formik.values.mobile_no} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Mobile No" />
                </div>
                
                {/* Lok Sabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Lok Sabha</Label>
                  <Input name="locksabha" value={formik.values.locksabha} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Lok Sabha" />
                </div>
                
                {/* Year */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Year</Label>
                  <Input name="year" value={formik.values.year} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" placeholder="Enter Year" />
                </div>
              </div>

              {/* Code Fields Section */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <h3 className="font-bold text-gray-800 dark:text-gray-100 text-lg mb-4">Additional Code</h3>
                <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                  {CODE_FIELDS.map((code) => (
                    <div key={code.key} className="flex items-center space-x-2">
                      <input
                        type="checkbox"
                        id={`code-${code.key}`}
                        name={code.key}
                        onChange={formik.handleChange}
                        checked={(formik.values as any)[code.key]}
                        className="h-4 w-4 rounded border-gray-300 text-[#368F8B] focus:ring-[#368F8B] dark:border-gray-700 dark:bg-gray-800 cursor-pointer"
                      />
                      <label htmlFor={`code-${code.key}`} className="text-xs font-medium leading-none cursor-pointer dark:text-gray-400">
                        {code.label}
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
                      Updating
                    </div>
                  ) : (
                    "Update"
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

export default EditMPVidhansabhaMember;
