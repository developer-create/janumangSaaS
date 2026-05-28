"use client";

import { useFormik } from "formik";
import { Button } from "@app/components/ui/button";
import { Input } from "@app/components/ui/input";
import { Label } from "@app/components/ui/label";
import { Card, CardContent } from "@app/components/ui/card";
import { Loader2 } from "lucide-react";
import {
  samitiMemberSchema,
  samitiMemberInitialValues,
  ISamitiMemberFormValues,
} from "./samitiMember.schema";

interface SamitiMemberFormProps {
  initialValues?: ISamitiMemberFormValues;
  onSubmit: (values: ISamitiMemberFormValues) => void;
  loading?: boolean;
}

const SamitiMemberForm = ({
  initialValues = samitiMemberInitialValues,
  onSubmit,
  loading = false,
}: SamitiMemberFormProps) => {
  const formik = useFormik<ISamitiMemberFormValues>({
    initialValues,
    enableReinitialize: true,
    validationSchema: samitiMemberSchema,
    onSubmit: (values) => {
      onSubmit(values);
    },
  });

  return (
    <Card className="border-0 shadow-none bg-transparent">
      <CardContent className="p-0">
        <form onSubmit={formik.handleSubmit} className="space-y-6">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div className="space-y-2">
              <Label htmlFor="memberName" className="text-gray-700 dark:text-gray-300">
                Member Name <span className="text-red-500">*</span>
              </Label>
              <Input
                id="memberName"
                name="memberName"
                placeholder="Enter member name"
                value={formik.values.memberName}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className={`dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200 ${
                  formik.touched.memberName && formik.errors.memberName
                    ? "border-red-500 focus-visible:ring-red-500"
                    : ""
                }`}
              />
              {formik.touched.memberName && formik.errors.memberName && (
                <p className="text-sm text-red-500">{formik.errors.memberName}</p>
              )}
            </div>

            <div className="space-y-2">
              <Label htmlFor="fatherName" className="text-gray-700 dark:text-gray-300">
                Father's Name
              </Label>
              <Input
                id="fatherName"
                name="fatherName"
                placeholder="Enter father's name"
                value={formik.values.fatherName}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className="dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200"
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor="age" className="text-gray-700 dark:text-gray-300">
                Age
              </Label>
              <Input
                id="age"
                name="age"
                type="number"
                placeholder="Enter age"
                value={formik.values.age}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className={`dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200 ${
                  formik.touched.age && formik.errors.age
                    ? "border-red-500 focus-visible:ring-red-500"
                    : ""
                }`}
              />
              {formik.touched.age && formik.errors.age && (
                <p className="text-sm text-red-500">{formik.errors.age}</p>
              )}
            </div>

            <div className="space-y-2">
              <Label htmlFor="position" className="text-gray-700 dark:text-gray-300">
                Position (पद)
              </Label>
              <Input
                id="position"
                name="position"
                placeholder="Enter position"
                value={formik.values.position}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className="dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200"
              />
            </div>

            <div className="space-y-2">
              <Label htmlFor="mobileNumber" className="text-gray-700 dark:text-gray-300">
                Mobile Number
              </Label>
              <Input
                id="mobileNumber"
                name="mobileNumber"
                placeholder="Enter mobile number"
                value={formik.values.mobileNumber}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className={`dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200 ${
                  formik.touched.mobileNumber && formik.errors.mobileNumber
                    ? "border-red-500 focus-visible:ring-red-500"
                    : ""
                }`}
              />
              {formik.touched.mobileNumber && formik.errors.mobileNumber && (
                <p className="text-sm text-red-500">{formik.errors.mobileNumber}</p>
              )}
            </div>

            <div className="space-y-2 md:col-span-2 lg:col-span-3">
              <Label htmlFor="remark" className="text-gray-700 dark:text-gray-300">
                Remark
              </Label>
              <Input
                id="remark"
                name="remark"
                placeholder="Enter any remarks"
                value={formik.values.remark}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className="dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-200"
              />
            </div>
          </div>

          <div className="flex justify-start gap-3 pt-6 mt-4 border-t border-gray-100 dark:border-gray-800">
            <Button
              type="button"
              variant="outline"
              onClick={() => window.history.back()}
              disabled={loading}
              className="dark:bg-[#202123] dark:border-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all"
            >
              Cancel
            </Button>
            <Button
              type="submit"
              className="bg-[#368F8B] hover:bg-[#2d7a76] text-white min-w-[120px] rounded-lg shadow-lg shadow-[#368F8B]/20 transition-all font-medium"
              disabled={loading}
            >
              {loading ? (
                <>
                  <Loader2 className="mr-2 h-4 w-4 animate-spin" />
                  Saving...
                </>
              ) : (
                "Save Member"
              )}
            </Button>
          </div>
        </form>
      </CardContent>
    </Card>
  );
};

export default SamitiMemberForm;
