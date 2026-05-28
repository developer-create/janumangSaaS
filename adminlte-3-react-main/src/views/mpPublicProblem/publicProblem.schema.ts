import * as Yup from "yup";
import { IPublicProblemFormValues } from "@app/types/publicProblem";
export type { IPublicProblemFormValues };

export const publicProblemSchema = Yup.object().shape({
  regNo: Yup.string().optional(),
  year: Yup.string().required("Year is required"),
  month: Yup.string().required("Month is required"),
  dateString: Yup.string().required("Date is required"),
  district: Yup.string().required("District is required"),
  approvedFund: Yup.string().required("Approved Fund is required"),
  workAgency: Yup.string().required("Work Agency is required"),
  // assembly: Yup.string().required("Assembly is required"),
  // block: Yup.string().required("Block is required"),
  // department: Yup.string().required("Department is required"),
  // status: Yup.string().required("Status is required"),
  middleMenContactNo: Yup.string()
    .optional()
    .test(
      "len",
      "Must be exactly 10 digits",
      (val) => !val || val.length === 10,
    ),
  beneficialMobile: Yup.string()
    .optional()
    .test(
      "len",
      "Must be exactly 10 digits",
      (val) => !val || val.length === 10,
    ),
});

export const publicProblemInitialValues: IPublicProblemFormValues = {
  srNo: "",
  regNo: "",
  timer: "",
  year: new Date().getFullYear().toString(),
  month: "",
  dateString: "",
  district: "",
  assembly: "",
  block: "",
  approvedFund: "",
  workAgency: "",
  recommendedLetterNo: "",
  boothNo: "",
  boothName: "",
  panchayatName: "",
  village: "",
  majraFaliya: "",
  workProblem: "",
  office: "",
  approximateCost: "",
  department: "",
  priority: "",
  typeOfWork: "",
  middleMen: "",
  middleMenContactNo: "",
  beneficialName: "",
  beneficialMobile: "", // Contact No for Beneficial

  sectorName: "",
  microSectorNo: "",
  microSectorName: "",
  tsNoDate: "",
  asNoDate: "",
  approvedFundOther: "",
  po: "",

  status: "Pending",
  remarkGoshana: "",
  remarkTipUsd: "",
  avedan: "",
  startLat: 0,
  startLong: 0,
};
