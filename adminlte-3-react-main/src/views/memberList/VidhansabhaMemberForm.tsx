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
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";

const validationSchema = Yup.object().shape({});

const VidhansabhaMemberForm = () => {
  const router = useRouter();
  const [isSubmitting, setIsSubmitting] = useState(false);
  
  // Dropdown data states
  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [villagesList, setVillagesList] = useState<any[]>([]);
  const [boothsList, setBoothsList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);
  const [samitisList, setSamitisList] = useState<any[]>([]);

  // Fetch functions
  useEffect(() => {
    fetchDistricts();
    fetchVidhansabha();
    fetchSamitis();
  }, []);

  const fetchDistricts = async () => {
    try {
      const res = await axios.get("/districts?limit=-1");
      console.log("Districts response:", res.data);
      setDistrictsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching districts:", err);
      // Fallback to hardcoded data
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
      const res = await axios.get("/vidhan-sabha?limit=-1");
      console.log("Vidhansabha response:", res.data);
      setVidhansabhaList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching vidhan sabha:", err);
      // Fallback to hardcoded data
      setVidhansabhaList([
        { _id: "1", name: "Nagpur Assembly" },
        { _id: "2", name: "Wardha Assembly" },
        { _id: "3", name: "Aurangabad Assembly" },
        { _id: "4", name: "Ahmedabad Assembly" },
        { _id: "5", name: "Indore Assembly" },
      ]);
    }
  };

  const fetchSamitis = async () => {
    try {
      const res = await axios.get("/samiti?limit=-1");
      console.log("Samitis response:", res.data);
      setSamitisList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching samitis:", err);
      // Fallback to hardcoded data
      setSamitisList([
        { _id: "1", name: "Ganesh Samiti" },
        { _id: "2", name: "Tenkar Samiti" },
        { _id: "3", name: "DP Samiti" },
        { _id: "4", name: "Mandir Samiti" },
        { _id: "5", name: "Bhagoria Samiti" },
        { _id: "6", name: "Nirman Samiti" },
        { _id: "7", name: "Booth Samiti" },
        { _id: "8", name: "Block Samiti" },
      ]);
    }
  };

  const fetchBlocks = async (districtId: string) => {
    try {
      const res = await axios.get(`/blocks?limit=-1&district=${districtId}`);
      console.log("Blocks response:", res.data);
      setBlocksList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching blocks:", err);
      // Fallback to hardcoded data
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
      console.log("Panchayats response:", res.data);
      setPanchayatsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching panchayats:", err);
      // Fallback to hardcoded data
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
      console.log("Villages response:", res.data);
      setVillagesList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching villages:", err);
      // Fallback to hardcoded data
      setVillagesList([
        { _id: "1", name: "Village A" },
        { _id: "2", name: "Village B" },
        { _id: "3", name: "Village C" },
        { _id: "4", name: "Village D" },
        { _id: "5", name: "Village E" },
      ]);
    }
  };

  const fetchBooths = async (blockId: string) => {
    try {
      const res = await axios.get(`/booths?limit=-1&block=${blockId}`);
      console.log("Booths response:", res.data);
      setBoothsList(res.data?.data || []);
    } catch (err) {
      console.error("Error fetching booths:", err);
      // Fallback to hardcoded data
      setBoothsList([
        { _id: "1", name: "Booth 001", code: "B001" },
        { _id: "2", name: "Booth 002", code: "B002" },
        { _id: "3", name: "Booth 003", code: "B003" },
        { _id: "4", name: "Booth 004", code: "B004" },
        { _id: "5", name: "Booth 005", code: "B005" },
      ]);
    }
  };

  const formik = useFormik({
    initialValues: {
      memberType: "vidhan-sabha",
      name: "",
      mobile: "",
      fatherName: "",
      age: "",
      gender: "",
      education: "",
      address: "",
      voterId: "",
      jaati: "",
      dob: "",
      dom: "",
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
      panchayat: "",
      village: "",
    },
    validationSchema,
    onSubmit: async (values) => {
      try {
        setIsSubmitting(true);
        console.log("Form submission started");
        console.log("Raw values:", values);
        
        // Convert all undefined values to empty strings
        const sanitizedValues = Object.keys(values).reduce((acc, key) => {
          acc[key] = (values as any)[key] === undefined ? "" : (values as any)[key];
          return acc;
        }, {} as any);
        
        console.log("Sanitized values:", sanitizedValues);
        
        const cleanedValues = {
          ...sanitizedValues,
          age: sanitizedValues.age === "" ? 0 : Number(sanitizedValues.age),
          postYear: sanitizedValues.postYear === "" ? 0 : Number(sanitizedValues.postYear),
          image: sanitizedValues.image === "" ? null : sanitizedValues.image,
        };
        console.log("Final values to submit:", cleanedValues);
        
        const response = await axios.post("/members", cleanedValues);
        console.log("Submit response:", response);
        
        toast.success("Member created successfully");
        router.push("/member-list");
      } catch (error: any) {
        console.error("Submit error:", error);
        console.error("Error response:", error.response?.data);
        toast.error(error.response?.data?.message || "Failed to submit");
      } finally {
        setIsSubmitting(false);
      }
    },
  });

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.CREATE_MEMBERS]}>
      <ContentHeader title="Create Member" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 mx-auto mt-6 max-w-4xl">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2 border-b border-gray-100 dark:border-gray-800 pb-4">
              Create New Member
            </h2>
            <form onSubmit={formik.handleSubmit} className="space-y-6 text-sm mt-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                {/* Samiti */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Samiti</Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("samiti", val)}
                    value={formik.values.samiti}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50">
                      <SelectValue placeholder="Select Samiti" />
                    </SelectTrigger>
                    <SelectContent>
                      {samitisList.map((s) => (
                        <SelectItem key={s._id} value={s.name}>{s.name}</SelectItem>
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

                {/* Panchayat */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Panchayat</Label>
                  <Select
                    onValueChange={(val) => {
                      const gp = panchayatsList.find((p) => p.name === val || p._id === val);
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

                {/* Booth Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Booth Name</Label>
                  <Select
                    onValueChange={(val) => {
                      const booth = boothsList.find((b) => b.name === val || b._id === val);
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

                {/* Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Name *</Label>
                  <Input
                    name="name"
                    value={formik.values.name}
                    onChange={formik.handleChange}
                    placeholder="Enter name"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Mobile */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Mobile</Label>
                  <Input
                    name="mobile"
                    value={formik.values.mobile}
                    onChange={formik.handleChange}
                    placeholder="Enter 10 digit mobile"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Father Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Father Name</Label>
                  <Input
                    name="fatherName"
                    value={formik.values.fatherName}
                    onChange={formik.handleChange}
                    placeholder="Enter father name"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Age */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Age</Label>
                  <Input
                    name="age"
                    type="number"
                    value={formik.values.age}
                    onChange={formik.handleChange}
                    placeholder="Enter age"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Gender */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Gender</Label>
                  <Input
                    name="gender"
                    value={formik.values.gender}
                    onChange={formik.handleChange}
                    placeholder="Enter gender"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Education */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Education</Label>
                  <Input
                    name="education"
                    value={formik.values.education}
                    onChange={formik.handleChange}
                    placeholder="Enter education"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Voter ID */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Voter ID</Label>
                  <Input
                    name="voterId"
                    value={formik.values.voterId}
                    onChange={formik.handleChange}
                    placeholder="Enter voter ID"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Jaati */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Jaati</Label>
                  <Input
                    name="jaati"
                    value={formik.values.jaati}
                    onChange={formik.handleChange}
                    placeholder="Enter jaati"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* DOB */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Date of Birth</Label>
                  <Input
                    name="dob"
                    type="date"
                    value={formik.values.dob}
                    onChange={formik.handleChange}
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* DOM */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Date of Marriage</Label>
                  <Input
                    name="dom"
                    type="date"
                    value={formik.values.dom}
                    onChange={formik.handleChange}
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Group */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Group</Label>
                  <Input
                    name="group"
                    value={formik.values.group}
                    onChange={formik.handleChange}
                    placeholder="Enter group"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Government Employee */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Government Employee</Label>
                  <Input
                    name="govtEmployee"
                    value={formik.values.govtEmployee}
                    onChange={formik.handleChange}
                    placeholder="Yes/No"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Party */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Party</Label>
                  <Input
                    name="party"
                    value={formik.values.party}
                    onChange={formik.handleChange}
                    placeholder="Enter party"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Code */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Code</Label>
                  <Input
                    name="code"
                    value={formik.values.code}
                    onChange={formik.handleChange}
                    placeholder="Enter code"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Vehicle */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Vehicle</Label>
                  <Input
                    name="vehicle"
                    value={formik.values.vehicle}
                    onChange={formik.handleChange}
                    placeholder="Enter vehicle"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Booth Number */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Booth Number</Label>
                  <Input
                    name="boothNumber"
                    value={formik.values.boothNumber}
                    readOnly
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Reference */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Reference</Label>
                  <Input
                    name="reference"
                    value={formik.values.reference}
                    onChange={formik.handleChange}
                    placeholder="Enter reference"
                    className="bg-gray-50 dark:bg-gray-800/50"
                  />
                </div>

                {/* Additional Codes / Flags */}
                <div className="space-y-3 md:col-span-2 pt-4 pb-2 border-t border-gray-200 dark:border-gray-800">
                  <h3 className="font-bold text-gray-800 dark:text-gray-100 text-lg">Additional Code</h3>
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
                          id={code.key}
                          name={code.key}
                          onChange={formik.handleChange}
                          checked={(formik.values as any)[code.key]}
                          className="h-4 w-4 rounded border-gray-300 text-[#368F8B] focus:ring-[#368F8B] dark:border-gray-700 dark:bg-gray-800"
                        />
                        <label htmlFor={code.key} className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 dark:text-gray-300">
                          {code.label}
                        </label>
                      </div>
                    ))}
                  </div>
                </div>

                {/* Address */}
                <div className="space-y-1.5 md:col-span-2">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Address</Label>
                  <Textarea
                    name="address"
                    value={formik.values.address}
                    onChange={formik.handleChange}
                    placeholder="Enter address"
                    className="bg-gray-50 dark:bg-gray-800/50"
                    rows={2}
                  />
                </div>

                {/* Remark */}
                <div className="space-y-1.5 md:col-span-2">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">Remark</Label>
                  <Textarea
                    name="remark"
                    value={formik.values.remark}
                    onChange={formik.handleChange}
                    placeholder="Enter remark"
                    className="bg-gray-50 dark:bg-gray-800/50"
                    rows={2}
                  />
                </div>
              </div>

              <div className="flex items-end justify-end gap-4 pt-4">
                <Button 
                  type="button" 
                  onClick={() => {
                    console.log("Form values:", formik.values);
                    console.log("Form errors:", formik.errors);
                    console.log("Form touched:", formik.touched);
                  }}
                  className="bg-gray-500 hover:bg-gray-600 w-32 font-bold text-lg h-12"
                >
                  Debug
                </Button>
                <Button type="submit" disabled={isSubmitting} className="bg-[#368F8B] hover:bg-[#2d7a76] w-32 font-bold text-lg h-12">
                  {isSubmitting ? "..." : "Submit"}
                </Button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </RouteGuard>
  );
};

export default VidhansabhaMemberForm;
