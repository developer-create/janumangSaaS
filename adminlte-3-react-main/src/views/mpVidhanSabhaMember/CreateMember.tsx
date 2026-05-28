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

const CODE_OPTIONS = [
  "SC", "YC", "WC", "PA", "SM", "EO", "X MLA", "BC (बूथ कमेटी)", "PP (पेज प्रभारी)", "IP (प्रभावशाली व्यक्ति)", "GS", "DCC", "PW", "NL", "FR", "SO", "FH (परिवार का मुखिया)", "SMM (सोशल मीडिया मित्र)", "MS (महिला समिति)", "FP (फलिया प्रभारी)", "ST", "REF", "US", "SMW", "DYC", "OBC", "ER (चुनाव प्रभारी)", "वरिष्ठ", "युवा", "वोटरप्रभारी(१० घर)", "DT", "DP", "MLA", "AVP", "MEET", "MEDIA", "BLA (बूथ लेवल एजेंट)", "FM (दानदाता)", "AK (नवीन सदस्य को सक्रिय करना)"
];

const validationSchema = Yup.object().shape({});

const CreateMember = () => {
  const router = useRouter();
  const [isSubmitting, setIsSubmitting] = useState(false);

  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [samitisList, setSamitisList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [villagesList, setVillagesList] = useState<any[]>([]);
  const [boothsList, setBoothsList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);

  useEffect(() => {
    fetchDistricts();
    fetchSamitis();
    fetchVidhansabha();
  }, []);

  const fetchDistricts = async () => {
    try {
      const res = await axios.get("/districts?limit=-1");
      setDistrictsList(res.data?.data || []);
    } catch (err) {}
  };

  const fetchSamitis = async () => {
    try {
      const res = await axios.get("/samiti?limit=-1");
      setSamitisList(res.data?.data || []);
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

  const fetchBooths = async (blockId: string) => {
    try {
      const res = await axios.get(`/booths?limit=-1&block=${blockId}`);
      setBoothsList(res.data?.data || []);
    } catch (err) {}
  };

  const formik = useFormik({
    initialValues: {
      district: "",
      vidhansabha: "",
      samiti: "",
      block: "",
      janpadPanchayat: "",
      mandalam: "",
      toll: "",
      postYear: "",
      boothName: "",
      boothNumber: "",
      grampanchayat: "",
      village: "",
      name: "",
      fatherName: "",
      jaati: "",
      gender: "",
      dob: "",
      age: "",
      dom: "",
      education: "",
      mobile: "",
      voterId: "",
      address: "",
      group: "",
      govtEmployee: "",
      party: "",
      code: "",
      nariSammanYojna: "",
      farmerLoanWaiver: "",
      vehicle: "",
      facebook: "",
      instagram: "",
      twitter: "",
      image: "",
      reference: "",
      remark: "",
      // 50 Boolean Roles
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

        await axios.post("/members", payload);
        toast.success("Survey form submitted successfully!");
        router.push("/member-list");
      } catch (error: any) {
        toast.error(error.response?.data?.message || "Failed to submit form");
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
      <ContentHeader title="Add Survey Details" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 mx-auto mt-6">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
              Survey Form
            </h2>
            <form onSubmit={formik.handleSubmit} className="space-y-6 text-sm">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                {/* Row 1 */}
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

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Samithi</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("samiti", val)}
                    value={formik.values.samiti}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Committee" />
                    </SelectTrigger>
                    <SelectContent>
                      {samitisList.map((s) => (
                        <SelectItem key={s._id} value={s.name}>{s.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Block Name</Label>
                  <Select
                    onValueChange={(val) => {
                      const block = blocksList.find((b) => b.name === val);
                      formik.setFieldValue("block", val);
                      if (block?._id) {
                        fetchPanchayats(block._id);
                        fetchBooths(block._id);
                      }
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

                {/* Row 2 */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Janpad Panchayat</Label>
                  <Input name="janpadPanchayat" value={formik.values.janpadPanchayat} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Mandalam</Label>
                  <Input name="mandalam" value={formik.values.mandalam} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Majra/Falia/Tolla</Label>
                  <Input name="toll" value={formik.values.toll} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Post-Year</Label>
                  <Input name="postYear" type="number" value={formik.values.postYear} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>

                {/* Row 3 */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Booth Name</Label>
                  <Select
                    onValueChange={(val) => {
                      const booth = boothsList.find((b) => b.name === val);
                      formik.setFieldValue("boothName", val);
                      formik.setFieldValue("boothNumber", booth?.code || "");
                    }}
                    value={formik.values.boothName}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Booth" />
                    </SelectTrigger>
                    <SelectContent>
                      {boothsList.map((b) => (
                        <SelectItem key={b._id} value={b.name}>{b.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Booth Number</Label>
                  <Input name="boothNumber" value={formik.values.boothNumber} readOnly className="bg-gray-100 dark:bg-gray-800/50 cursor-not-allowed" />
                </div>

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Gram Panchayat</Label>
                  <Select
                    onValueChange={(val) => {
                      const gp = panchayatsList.find((p) => p.name === val);
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

                {/* Row 4 */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Name</Label>
                  <Input name="name" value={formik.values.name} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Father&apos;s Name</Label>
                  <Input name="fatherName" value={formik.values.fatherName} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Caste</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("jaati", val)} value={formik.values.jaati}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Caste" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="ST">ST</SelectItem>
                      <SelectItem value="SC">SC</SelectItem>
                      <SelectItem value="OBC">OBC</SelectItem>
                      <SelectItem value="GEN">GEN</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Gender</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("gender", val)} value={formik.values.gender}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Gender" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Male">Male</SelectItem>
                      <SelectItem value="Female">Female</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                {/* Row 5 */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Date of Birth</Label>
                  <Input type="date" name="dob" value={formik.values.dob} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Age</Label>
                  <Input type="number" name="age" value={formik.values.age} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Date of Marriage</Label>
                  <Input type="date" name="dom" value={formik.values.dom} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Education</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("education", val)} value={formik.values.education}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Education" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Literate">Literate</SelectItem>
                      <SelectItem value="Illiterate">Illiterate</SelectItem>
                      <SelectItem value="10th">10th</SelectItem>
                      <SelectItem value="12th">12th</SelectItem>
                      <SelectItem value="Graduate">Graduate</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                {/* Row 6 */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Mobile</Label>
                  <Input name="mobile" maxLength={10} value={formik.values.mobile} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Voter Code</Label>
                  <Input name="voterId" value={formik.values.voterId} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5 col-span-1 md:col-span-2 xl:col-span-1">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Address</Label>
                  <Textarea name="address" value={formik.values.address} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" rows={2} />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Group</Label>
                  <Input name="group" value={formik.values.group} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>

                {/* Row 7 */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Government Employee</Label>
                  <Input name="govtEmployee" value={formik.values.govtEmployee} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Party</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("party", val)} value={formik.values.party}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Party" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="BJP">BJP</SelectItem>
                      <SelectItem value="Congress">Congress</SelectItem>
                      <SelectItem value="AAP">AAP</SelectItem>
                      <SelectItem value="BSP">BSP</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
              </div>

              {/* Code Section (Legacy String Array) */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <Label className="font-bold text-gray-700 dark:text-gray-200 text-lg mb-4 block">Code</Label>
                <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-y-3 gap-x-2">
                  {CODE_OPTIONS.map((opt) => (
                    <div key={opt} className="flex items-center space-x-2">
                      <Checkbox
                        id={`code-${opt}`}
                        checked={(formik.values.code || "").split(",").includes(opt)}
                        onCheckedChange={(checked) => handleCheckboxChange("code", opt, !!checked)}
                      />
                      <label htmlFor={`code-${opt}`} className="text-xs font-medium leading-none cursor-pointer dark:text-gray-400">
                        {opt}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              {/* Additional Codes / Flags (50 Boolean Roles) */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <h3 className="font-bold text-gray-800 dark:text-gray-100 text-lg mb-4">Additional Code (Flags)</h3>
                <div className="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                  {[
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
                    { key: "ref_code", label: "REF" }
                  ].map((code) => (
                    <div key={code.key} className="flex items-center space-x-2">
                      <input
                        type="checkbox"
                        id={`addcode-${code.key}`}
                        name={code.key}
                        onChange={formik.handleChange}
                        checked={(formik.values as any)[code.key]}
                        className="h-4 w-4 rounded border-gray-300 text-[#368F8B] focus:ring-[#368F8B] dark:border-gray-700 dark:bg-gray-800 cursor-pointer"
                      />
                      <label htmlFor={`addcode-${code.key}`} className="text-sm font-medium leading-none cursor-pointer dark:text-gray-400">
                        {code.label}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              {/* Bottom Section */}
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 pt-6 border-t border-gray-100 dark:border-gray-800 mt-6">
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Nari Samman Yojana</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("nariSammanYojna", val)} value={formik.values.nariSammanYojna}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Option" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Yes">Yes</SelectItem>
                      <SelectItem value="No">No</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Farmer Loan Waiver</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("farmerLoanWaiver", val)} value={formik.values.farmerLoanWaiver}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Option" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Yes">Yes</SelectItem>
                      <SelectItem value="No">No</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Vehicle</Label>
                  <Select onValueChange={(val) => formik.setFieldValue("vehicle", val)} value={formik.values.vehicle}>
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Vehicle" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="2 wheeler">2 wheeler</SelectItem>
                      <SelectItem value="4 wheeler">4 wheeler</SelectItem>
                      <SelectItem value="Koi Vahan nhi">Koi Vahan nhi</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Facebook</Label>
                  <Input name="facebook" value={formik.values.facebook} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Instagram</Label>
                  <Input name="instagram" value={formik.values.instagram} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Twitter</Label>
                  <Input name="twitter" value={formik.values.twitter} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>
                
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Image</Label>
                  <div className="flex items-center gap-2">
                    <Input type="file" className="bg-gray-50 dark:bg-gray-800/50 cursor-pointer" />
                  </div>
                </div>

                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Reference</Label>
                  <Input name="reference" value={formik.values.reference} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
                </div>

                <div className="space-y-1.5 col-span-1 md:col-span-2">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Remark</Label>
                  <Input name="remark" value={formik.values.remark} onChange={formik.handleChange} className="bg-gray-50 dark:bg-gray-800/50" />
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
              </div>
            </form>
          </div>
        </div>
      </section>
    </RouteGuard>
  );
};

export default CreateMember;
