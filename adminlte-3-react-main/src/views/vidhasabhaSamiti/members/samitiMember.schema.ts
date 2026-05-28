import * as Yup from "yup";

export interface ISamitiMemberFormValues {
  memberName: string;
  fatherName: string;
  age: number | "";
  position: string;
  mobileNumber: string;
  remark: string;
}

export const samitiMemberSchema = Yup.object().shape({
  memberName: Yup.string().required("Member name is required"),
  fatherName: Yup.string(),
  age: Yup.number()
    .typeError("Age must be a number")
    .min(0, "Age cannot be negative")
    .max(150, "Invalid age"),
  position: Yup.string(),
  mobileNumber: Yup.string().matches(/^[0-9]{10}$/, {
    message: "Mobile number must be exactly 10 digits",
    excludeEmptyString: true,
  }),
  remark: Yup.string(),
});

export const samitiMemberInitialValues: ISamitiMemberFormValues = {
  memberName: "",
  fatherName: "",
  age: "",
  position: "",
  mobileNumber: "",
  remark: "",
};
