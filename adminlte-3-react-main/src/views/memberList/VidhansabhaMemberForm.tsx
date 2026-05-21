"use client";

import { useState, useRef, useEffect } from "react";
import { useRouter } from "next/navigation";
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

const CODE_OPTIONS = [
  { label: "BC (बूथ कमेटी)", value: "BC" },
  { label: "PP (पेज प्रभारी)", value: "PP" },
  { label: "IP (प्रभावशाली व्यक्ति)", value: "IP" },
  { label: "FH (परिवार का मुखिया)", value: "FH" },
  { label: "SMM (सोशल मीडिया मित्र)", value: "SMM" },
  { label: "MS (महिला समिति)", value: "MS" },
  { label: "FP (फलिया प्रभारी)", value: "FP" },
  { label: "ER (चुनाव प्रभारी)", value: "ER" },
  { label: "वरिष्ठ", value: "वरिष्ठ" },
  { label: "युवा", value: "युवा" },
  { label: "BLA (बूथ लेवल एजेंट)", value: "BLA" },
  { label: "FM (दानदाता)", value: "FM" },
  { label: "AK (नवीन सदस्य को सक्रिय करना)", value: "AK" },
  { label: "वोटर प्रभारी (10 घर)", value: "वोटर प्रभारी" },
];

const VEHICLE_OPTIONS = [
  { label: "2 wheeler", value: "2 wheeler" },
  { label: "4 wheeler", value: "4 wheeler" },
  { label: "Koi Vahan nhi", value: "Koi Vahan nhi" },
];

const validationSchema = Yup.object().shape({
  district: Yup.string().required("District is required"),
  vidhansabha: Yup.string().required("Vidhan Sabha is required"),
  block: Yup.string().required("Block is required"),
  panchayat: Yup.string().required("Panchayat is required"),
  village: Yup.string().required("Village is required"),
  name: Yup.string().required("Name is required"),
  mobile: Yup.string()
    .matches(/^[0-9]{10}$/, "Must be exactly 10 digits")
    .optional(),
});

const VidhansabhaMemberForm = () => {
  const router = useRouter();
  const [isSubmitting, setIsSubmitting] = useState(false);
  const fileInputRef = useRef<HTMLInputElement>(null);
  const [fileName, setFileName] = useState("");

  // Dynamic Lists
  const [districtsList, setDistrictsList] = useState<any[]>([]);
  const [blocksList, setBlocksList] = useState<any[]>([]);
  const [panchayatsList, setPanchayatsList] = useState<any[]>([]);
  const [villagesList, setVillagesList] = useState<any[]>([]);
  const [boothsList, setBoothsList] = useState<any[]>([]);
  const [vidhansabhaList, setVidhansabhaList] = useState<any[]>([]);

  useEffect(() => {
    fetchDistricts();
    fetchVidhansabha();
  }, []);

  const fetchDistricts = async () => {
    try {
      const res = await axios.get("/districts?limit=-1");
      setDistrictsList(res.data?.data || []);
    } catch (err) {
      console.error("Failed to fetch districts", err);
    }
  };

  const fetchVidhansabha = async () => {
    try {
      const res = await axios.get("/vidhan-sabha?limit=-1");
      setVidhansabhaList(res.data?.data || []);
    } catch (err) {
      console.error("Failed to fetch vidhan sabha", err);
    }
  };

  const fetchBlocks = async (districtId: string) => {
    try {
      const res = await axios.get(`/blocks?limit=-1&district=${districtId}`);
      setBlocksList(res.data?.data || []);
    } catch (err) {
      console.error("Failed to fetch blocks", err);
    }
  };

  const fetchPanchayats = async (blockId: string) => {
    try {
      const res = await axios.get(`/panchayat?limit=-1&block=${blockId}`);
      setPanchayatsList(res.data?.data || []);
    } catch (err) {
      console.error("Failed to fetch panchayats", err);
    }
  };

  const fetchVillages = async (panchayatId: string) => {
    try {
      const res = await axios.get(`/villages?limit=-1&panchayat=${panchayatId}`);
      setVillagesList(res.data?.data || []);
    } catch (err) {
      console.error("Failed to fetch villages", err);
    }
  };

  const fetchBooths = async (blockId: string) => {
    try {
      const res = await axios.get(`/booths?limit=-1&block=${blockId}`);
      setBoothsList(res.data?.data || []);
    } catch (err) {
      console.error("Failed to fetch booths", err);
    }
  };

  const formik = useFormik({
    initialValues: {
      district: "",
      vidhansabha: "",
      block: "",
      panchayat: "",
      village: "",
      boothName: "",
      boothNumber: "",
      name: "",
      fatherName: "",
      jaati: "",
      dob: "",
      age: 0,
      dom: "",
      education: "",
      mobile: "",
      voterId: "",
      address: "",
      gender: "",
      group: "",
      vehicle: "",
      govtEmployee: "",
      party: "",
      postYear: 0,
      code: "",
      toll: "",
      remark: "",
      image: "",
    },
    validationSchema,
    onSubmit: async (values) => {
      try {
        setIsSubmitting(true);
        const cleanedValues = {
          ...values,
          age: values.age === 0 ? 0 : Number(values.age),
          postYear: values.postYear === 0 ? 0 : Number(values.postYear),
          image: values.image === "" ? null : values.image,
          memberType: "vidhan-sabha",
        };
        await axios.post("/members", cleanedValues);
        toast.success("Vidhan Sabha Member created successfully");
        router.push("/member-list");
      } catch (error: any) {
        toast.error(error.response?.data?.message || "Failed to create member");
      } finally {
        setIsSubmitting(false);
      }
    },
  });

  const handleCheckboxChange = (
    field: "code" | "vehicle",
    value: string,
    checked: boolean,
  ) => {
    const currentValues = (
      formik.values[field] ? formik.values[field].split(",") : []
    ).filter((v) => v !== "");
    if (checked) {
      formik.setFieldValue(field, [...currentValues, value].join(","));
    } else {
      formik.setFieldValue(
        field,
        currentValues.filter((v) => v !== value).join(","),
      );
    }
  };

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.CREATE_MEMBERS]}>
      <ContentHeader title="Add Vidhan Sabha Member" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 p-8 max-w-5xl mx-auto mt-6">
            <h2 className="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 border-b border-gray-100 dark:border-gray-800 pb-4">
              Vidhan Sabha Member Form
            </h2>
            <form onSubmit={formik.handleSubmit} className="space-y-8 text-sm">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-6">
                {/* District */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    District <span className="text-red-500">*</span>
                  </Label>
                  <Select
                    onValueChange={(val) => {
                      const dist = districtsList.find((d) => d.name === val);
                      formik.setFieldValue("district", val);
                      if (dist?._id) fetchBlocks(dist._id);
                    }}
                    value={formik.values.district}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select District" />
                    </SelectTrigger>
                    <SelectContent>
                      {districtsList.map((d) => (
                        <SelectItem key={d._id} value={d.name}>
                          {d.name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.errors.district && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.district}
                    </p>
                  )}
                </div>

                {/* Vidhan Sabha */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Vidhan Sabha <span className="text-red-500">*</span>
                  </Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("vidhansabha", val)}
                    value={formik.values.vidhansabha}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select Vidhan Sabha" />
                    </SelectTrigger>
                    <SelectContent>
                      {vidhansabhaList.map((vs) => (
                        <SelectItem key={vs._id} value={vs.name}>
                          {vs.name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.errors.vidhansabha && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.vidhansabha}
                    </p>
                  )}
                </div>

                {/* Block Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Block Name <span className="text-red-500">*</span>
                  </Label>
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
                    disabled={!formik.values.district}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select Block" />
                    </SelectTrigger>
                    <SelectContent>
                      {blocksList.map((b) => (
                        <SelectItem key={b._id} value={b.name}>
                          {b.name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.errors.block && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.block}
                    </p>
                  )}
                </div>

                {/* Booth Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Booth Name
                  </Label>
                  <Select
                    onValueChange={(val) => {
                      const booth = boothsList.find((b) => b.name === val);
                      formik.setFieldValue("boothName", val);
                      formik.setFieldValue("boothNumber", booth?.code || "");
                    }}
                    value={formik.values.boothName}
                    disabled={!formik.values.block}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select Booth" />
                    </SelectTrigger>
                    <SelectContent>
                      {boothsList.map((b) => (
                        <SelectItem key={b._id} value={b.name}>
                          {b.name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Booth Number */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Booth Number
                  </Label>
                  <Input
                    name="boothNumber"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.boothNumber}
                    onChange={formik.handleChange}
                    placeholder="Booth Number"
                    readOnly
                  />
                </div>

                {/* Gram Panchayat */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Gram Panchayat <span className="text-red-500">*</span>
                  </Label>
                  <Select
                    onValueChange={(val) => {
                      const gp = panchayatsList.find((p) => p.name === val);
                      formik.setFieldValue("panchayat", val);
                      if (gp?._id) fetchVillages(gp._id);
                    }}
                    value={formik.values.panchayat}
                    disabled={!formik.values.block}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select Panchayat" />
                    </SelectTrigger>
                    <SelectContent>
                      {panchayatsList.map((p) => (
                        <SelectItem key={p._id} value={p.name}>
                          {p.name}
                        </SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.errors.panchayat && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.panchayat}
                    </p>
                  )}
                </div>

                {/* Village */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Village <span className="text-red-500">*</span>
                  </Label>
                  <Input
                    name="village"
                    list="villages-options"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.village}
                    onChange={formik.handleChange}
                    placeholder="Type or Select Village"
                  />
                  <datalist id="villages-options">
                    {villagesList.map((v) => (
                      <option key={v._id} value={v.name} />
                    ))}
                  </datalist>
                  {formik.errors.village && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.village}
                    </p>
                  )}
                </div>

                {/* Majra/Falia/Tolla */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Majra/Falia/Tolla
                  </Label>
                  <Input
                    name="toll"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.toll}
                    onChange={formik.handleChange}
                    placeholder="Enter Majra/Falia/Tolla"
                  />
                </div>

                {/* Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Name <span className="text-red-500">*</span>
                  </Label>
                  <Input
                    name="name"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.name}
                    onChange={formik.handleChange}
                    placeholder="Enter Name"
                  />
                  {formik.errors.name && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.name}
                    </p>
                  )}
                </div>

                {/* Father's Name */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Father&apos;s Name
                  </Label>
                  <Input
                    name="fatherName"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.fatherName}
                    onChange={formik.handleChange}
                    placeholder="Enter Father's Name"
                  />
                </div>

                {/* Caste */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Caste
                  </Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("jaati", val)}
                    value={formik.values.jaati}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
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

                {/* Date of Birth */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Date of Birth
                  </Label>
                  <Input
                    type="date"
                    name="dob"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.dob}
                    onChange={formik.handleChange}
                  />
                </div>

                {/* Age */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Age
                  </Label>
                  <Input
                    type="text"
                    name="age"
                    inputMode="numeric"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.age}
                    onChange={(e) => {
                      const value = e.target.value.replace(/\D/g, "");
                      if (value.length <= 3) {
                        formik.setFieldValue("age", value);
                      }
                    }}
                    placeholder="Enter Age"
                  />
                </div>

                {/* Date of Marriage */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Date of Marriage
                  </Label>
                  <Input
                    type="date"
                    name="dom"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.dom}
                    onChange={formik.handleChange}
                  />
                </div>

                {/* Education */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Education
                  </Label>
                  <Select
                    onValueChange={(val) =>
                      formik.setFieldValue("education", val)
                    }
                    value={formik.values.education}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
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

                {/* Mobile */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Mobile
                  </Label>
                  <Input
                    name="mobile"
                    type="text"
                    maxLength={10}
                    inputMode="numeric"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.mobile}
                    onChange={(e) => {
                      const value = e.target.value.replace(/\D/g, "");
                      if (value.length <= 10) {
                        formik.setFieldValue("mobile", value);
                      }
                    }}
                    placeholder="Enter Mobile Number"
                  />
                  {formik.errors.mobile && (
                    <p className="text-red-500 text-sm mt-1">
                      {formik.errors.mobile}
                    </p>
                  )}
                </div>

                {/* Voter Code */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Voter Code
                  </Label>
                  <Input
                    name="voterId"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.voterId}
                    onChange={formik.handleChange}
                    placeholder="Enter Voter Code"
                  />
                </div>

                {/* Address */}
                <div className="space-y-1.5 lg:col-span-2">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Address
                  </Label>
                  <Textarea
                    name="address"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200 min-h-[80px]"
                    value={formik.values.address}
                    onChange={formik.handleChange}
                    placeholder="Enter Address"
                  />
                </div>

                {/* Gender */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Gender
                  </Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("gender", val)}
                    value={formik.values.gender}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select Gender" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Male">Male</SelectItem>
                      <SelectItem value="Female">Female</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                {/* Group */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Group
                  </Label>
                  <Input
                    name="group"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.group}
                    onChange={formik.handleChange}
                    placeholder="Enter Group"
                  />
                </div>

                {/* Vehicle */}
                <div className="space-y-1.5 lg:pt-0 pt-4">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Vehicle
                  </Label>
                  <div className="flex flex-col gap-2 pt-1">
                    {VEHICLE_OPTIONS.map((opt) => (
                      <div
                        key={opt.value}
                        className="flex items-center space-x-2"
                      >
                        <Checkbox
                          id={`v-${opt.value}`}
                          checked={(formik.values.vehicle || "")
                            .split(",")
                            .includes(opt.value)}
                          onCheckedChange={(checked) =>
                            handleCheckboxChange(
                              "vehicle",
                              opt.value,
                              !!checked,
                            )
                          }
                        />
                        <label
                          htmlFor={`v-${opt.value}`}
                          className="text-sm font-medium leading-none cursor-pointer dark:text-gray-400"
                        >
                          {opt.label}
                        </label>
                      </div>
                    ))}
                  </div>
                </div>

                {/* Government Employee */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Government Employee
                  </Label>
                  <Input
                    name="govtEmployee"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                    value={formik.values.govtEmployee}
                    onChange={formik.handleChange}
                    placeholder="Enter Government Employee"
                  />
                </div>

                {/* Party */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Party
                  </Label>
                  <Select
                    onValueChange={(val) => formik.setFieldValue("party", val)}
                    value={formik.values.party}
                  >
                    <SelectTrigger className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200">
                      <SelectValue placeholder="Select Party" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="BJP">BJP</SelectItem>
                      <SelectItem value="Congress">Congress</SelectItem>
                      <SelectItem value="AAP">AAP</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                {/* Post-Year */}
                <div className="space-y-1.5">
                  <Label className="font-bold text-gray-700 dark:text-gray-300">
                    Post-Year
                  </Label>
                  <Input
                    name="postYear"
                    type="number"
                    className="bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200 no-spinner"
                    value={formik.values.postYear}
                    onChange={formik.handleChange}
                    placeholder="Enter Post-Year"
                  />
                </div>
              </div>

              {/* Code Section */}
              <div className="pt-6 border-t border-gray-100 dark:border-gray-800">
                <Label className="font-bold text-gray-700 dark:text-gray-200 text-lg mb-4 block">
                  Code
                </Label>
                <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-y-4 gap-x-2">
                  {CODE_OPTIONS.map((opt) => (
                    <div
                      key={opt.value}
                      className="flex items-center space-x-2"
                    >
                      <Checkbox
                        id={`code-${opt.value}`}
                        checked={(formik.values.code || "")
                          .split(",")
                          .includes(opt.value)}
                        onCheckedChange={(checked) =>
                          handleCheckboxChange("code", opt.value, !!checked)
                        }
                      />
                      <label
                        htmlFor={`code-${opt.value}`}
                        className="text-xs font-medium leading-none cursor-pointer dark:text-gray-400"
                      >
                        {opt.label}
                      </label>
                    </div>
                  ))}
                </div>
              </div>

              {/* Remark */}
              <div>
                <Label htmlFor="remark" className="font-bold text-gray-700 dark:text-gray-300">
                  Remark
                </Label>
                <Textarea
                  id="remark"
                  name="remark"
                  placeholder="Enter Remark"
                  value={formik.values.remark}
                  onChange={formik.handleChange}
                  className="mt-2 bg-gray-50 dark:bg-gray-800/50 border-gray-300 dark:border-gray-700 dark:text-gray-200"
                  rows={4}
                />
              </div>

              {/* Buttons */}
              <div className="flex gap-4 justify-end pt-6 border-t border-gray-100 dark:border-gray-800">
                <Button
                  type="button"
                  variant="outline"
                  onClick={() => router.back()}
                >
                  Cancel
                </Button>
                <Button
                  type="submit"
                  disabled={isSubmitting}
                  className="bg-[#368F8B] hover:bg-[#2d7a76]"
                >
                  {isSubmitting ? "Submitting..." : "Submit"}
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
