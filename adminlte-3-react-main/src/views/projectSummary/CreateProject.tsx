"use client";

import { useState, useEffect } from "react";
import { useRouter } from "@app/hooks/useCustomRouter";

import { useFormik } from "formik";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { handleError } from "@app/utils/errorHandler";
import { projectSchema, projectInitialValues } from "./project.schema";

import { Input } from "@app/components/ui/input";
import { Textarea } from "@app/components/ui/textarea";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { Button } from "@app/components/ui/button";
import { Label } from "@app/components/ui/label";
import { ContentHeader } from "@app/components";
import { RouteGuard } from '@app/components/RouteGuard';
import { PERMISSIONS } from "@app/config/permissions";

const CreateProject = () => {
  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.MANAGE_ROLES, PERMISSIONS.CREATE_PROJECTS]}>
      <CreateProjectContent />
    </RouteGuard>
  );
};

const CreateProjectContent = () => {
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const [statesList, setStatesList] = useState([]);
  const [divisionsList, setDivisionsList] = useState([]);
  const [districtsList, setDistrictsList] = useState([]);
  const [blocksList, setBlocksList] = useState([]);
  const [departmentsList, setDepartmentsList] = useState([]);

  const [selectedState, setSelectedState] = useState("");
  const [selectedDivision, setSelectedDivision] = useState("");

  const formik = useFormik({
    initialValues: projectInitialValues,
    validationSchema: projectSchema,
    onSubmit: async (values) => {
      setLoading(true);
      try {
        const payload = {
          ...values,
          projectCost: Number(values.projectCost) || 0,
          proposalEstimate: Number(values.proposalEstimate) || 0,
        };
        await axios.post("/projects", payload);
        toast.success("Project created successfully!");
        router.push("/project-summary");
      } catch (error: unknown) {
        handleError(error, "Failed to create project");
      } finally {
        setLoading(false);
      }
    },
  });

  useEffect(() => {
    fetchStates();
    fetchBlocks();
    fetchDepartments();
  }, []);

  useEffect(() => {
    if (selectedState) {
      fetchDivisions(selectedState);
    } else {
      setDivisionsList([]);
      setDistrictsList([]);
      setSelectedDivision("");
    }
  }, [selectedState]);

  useEffect(() => {
    if (selectedDivision) {
      fetchDistricts(selectedDivision);
    } else {
      setDistrictsList([]);
    }
  }, [selectedDivision]);

  const fetchStates = async () => {
    try {
      const { data } = await axios.get("/states");
      setStatesList(data.data || []);
    } catch (error: unknown) {
      handleError(error, "Failed to fetch states");
    }
  };

  const fetchDivisions = async (stateId: string) => {
    try {
      const { data } = await axios.get(`/divisions?state=${stateId}&limit=-1`);
      setDivisionsList(data.data || []);
    } catch (error: unknown) {
      handleError(error, "Failed to fetch divisions");
    }
  };

  const fetchDistricts = async (divisionId: string) => {
    try {
      const { data } = await axios.get(
        `/districts?division=${divisionId}&limit=-1`,
      );
      setDistrictsList(data.data || []);
    } catch (error: unknown) {
      handleError(error, "Failed to fetch districts");
    }
  };

  const fetchBlocks = async () => {
    try {
      const { data } = await axios.get("/blocks?limit=-1");
      setBlocksList(data.data || []);
    } catch (error: unknown) {
      handleError(error, "Failed to fetch blocks");
    }
  };

  const fetchDepartments = async () => {
    try {
      const { data } = await axios.get("/departments?limit=-1");
      setDepartmentsList(data.data || []);
    } catch (error: unknown) {
      handleError(error, "Failed to fetch departments");
    }
  };

  return (
    <>
      <ContentHeader title="Create Project" />
      <section className="content">
        <div className="container-fluid px-4">
          <div className="bg-white rounded-xl shadow-lg border border-gray-200 mt-6 max-w-5xl mx-auto">
            <div className="p-6 border-b border-gray-200">
              <h2 className="text-2xl font-bold text-gray-800">
                Create New Project
              </h2>
              <p className="text-gray-600 mt-1">
                Fill in the details to add a new project.
              </p>
            </div>

            <form onSubmit={formik.handleSubmit} className="p-8">
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                {/* Keep State/Division for Saas architecture, but make them blend in */}
                <div className="space-y-2">
                  <Label>State <span className="text-red-500">*</span></Label>
                  <Select value={selectedState} onValueChange={setSelectedState}>
                    <SelectTrigger><SelectValue placeholder="Select state" /></SelectTrigger>
                    <SelectContent>
                      {statesList.map((st: any) => (
                        <SelectItem key={st._id} value={st._id}>{st.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>
                <div className="space-y-2">
                  <Label>Division <span className="text-red-500">*</span></Label>
                  <Select value={selectedDivision} onValueChange={setSelectedDivision} disabled={!selectedState}>
                    <SelectTrigger><SelectValue placeholder="Select division" /></SelectTrigger>
                    <SelectContent>
                      {divisionsList.map((div: any) => (
                        <SelectItem key={div._id} value={div._id}>{div.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                </div>

                {/* Legacy Row 1: District | Block */}
                <div className="space-y-2">
                  <Label>District <span className="text-red-500">*</span></Label>
                  <Select value={formik.values.district} onValueChange={(v) => formik.setFieldValue("district", v)} disabled={!selectedDivision}>
                    <SelectTrigger className={formik.touched.district && formik.errors.district ? "border-red-500" : ""}>
                      <SelectValue placeholder="Select District" />
                    </SelectTrigger>
                    <SelectContent>
                      {districtsList.map((dist: any) => (
                        <SelectItem key={dist._id} value={dist.name}>{dist.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.touched.district && formik.errors.district && <p className="text-red-500 text-xs">{formik.errors.district}</p>}
                </div>
                <div className="space-y-2">
                  <Label>Block <span className="text-red-500">*</span></Label>
                  <Select value={formik.values.block} onValueChange={(v) => formik.setFieldValue("block", v)}>
                    <SelectTrigger className={formik.touched.block && formik.errors.block ? "border-red-500" : ""}>
                      <SelectValue placeholder="Select Block" />
                    </SelectTrigger>
                    <SelectContent>
                      {blocksList.map((blk: any) => (
                        <SelectItem key={blk._id} value={blk.name}>{blk.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.touched.block && formik.errors.block && <p className="text-red-500 text-xs">{formik.errors.block}</p>}
                </div>

                {/* Legacy Row 2: Department | Work Name */}
                <div className="space-y-2">
                  <Label>Department <span className="text-red-500">*</span></Label>
                  <Select value={formik.values.department} onValueChange={(v) => formik.setFieldValue("department", v)}>
                    <SelectTrigger className={formik.touched.department && formik.errors.department ? "border-red-500" : ""}>
                      <SelectValue placeholder="Select Department" />
                    </SelectTrigger>
                    <SelectContent>
                      {departmentsList.map((dept: any) => (
                        <SelectItem key={dept._id} value={dept.name}>{dept.name}</SelectItem>
                      ))}
                    </SelectContent>
                  </Select>
                  {formik.touched.department && formik.errors.department && <p className="text-red-500 text-xs">{formik.errors.department}</p>}
                </div>
                <div className="space-y-2">
                  <Label htmlFor="workName">Work Name <span className="text-red-500">*</span></Label>
                  <Input id="workName" name="workName" value={formik.values.workName} onChange={formik.handleChange} onBlur={formik.handleBlur} className={formik.touched.workName && formik.errors.workName ? "border-red-500" : ""} />
                  {formik.touched.workName && formik.errors.workName && <p className="text-red-500 text-xs">{formik.errors.workName}</p>}
                </div>

                {/* Legacy Row 3: Project Cost | Proposal Estimate */}
                <div className="space-y-2">
                  <Label htmlFor="projectCost">Project Cost (₹) <span className="text-red-500">*</span></Label>
                  <Input id="projectCost" name="projectCost" type="number" step="0.01" value={formik.values.projectCost} onChange={formik.handleChange} onBlur={formik.handleBlur} className={formik.touched.projectCost && formik.errors.projectCost ? "border-red-500" : ""} />
                  {formik.touched.projectCost && formik.errors.projectCost && <p className="text-red-500 text-xs">{formik.errors.projectCost}</p>}
                </div>
                <div className="space-y-2">
                  <Label htmlFor="proposalEstimate">Proposal Estimate (₹) <span className="text-red-500">*</span></Label>
                  <Input id="proposalEstimate" name="proposalEstimate" type="number" step="0.01" value={formik.values.proposalEstimate} onChange={formik.handleChange} onBlur={formik.handleBlur} className={formik.touched.proposalEstimate && formik.errors.proposalEstimate ? "border-red-500" : ""} />
                  {formik.touched.proposalEstimate && formik.errors.proposalEstimate && <p className="text-red-500 text-xs">{formik.errors.proposalEstimate}</p>}
                </div>

                {/* Legacy Row 4: Status | Officer Name */}
                <div className="space-y-2">
                  <Label>Status <span className="text-red-500">*</span></Label>
                  <Select value={formik.values.status} onValueChange={(v) => formik.setFieldValue("status", v)}>
                    <SelectTrigger className={formik.touched.status && formik.errors.status ? "border-red-500" : ""}>
                      <SelectValue placeholder="Select Status" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Pending">Pending</SelectItem>
                      <SelectItem value="In Progress">In Progress</SelectItem>
                      <SelectItem value="Completed">Completed</SelectItem>
                      <SelectItem value="On Hold">On Hold</SelectItem>
                      <SelectItem value="Cancelled">Cancelled</SelectItem>
                    </SelectContent>
                  </Select>
                  {formik.touched.status && formik.errors.status && <p className="text-red-500 text-xs">{formik.errors.status}</p>}
                </div>
                <div className="space-y-2">
                  <Label htmlFor="officerName">Officer Name</Label>
                  <Input id="officerName" name="officerName" value={formik.values.officerName} onChange={formik.handleChange} onBlur={formik.handleBlur} />
                </div>

                {/* Legacy Row 5: Contact Number */}
                <div className="space-y-2">
                  <Label htmlFor="contactNumber">Contact Number</Label>
                  <Input id="contactNumber" name="contactNumber" value={formik.values.contactNumber} onChange={formik.handleChange} onBlur={formik.handleBlur} placeholder="10 digits only" className={formik.touched.contactNumber && formik.errors.contactNumber ? "border-red-500" : ""} />
                  {formik.touched.contactNumber && formik.errors.contactNumber && <p className="text-red-500 text-xs">{formik.errors.contactNumber}</p>}
                </div>
                <div className="space-y-2">
                   {/* Empty div to match grid alignment if needed, or we just leave it for the next row */}
                </div>

                {/* Legacy Row 6: Technical Session | Administrative Session */}
                <div className="space-y-2">
                  <Label htmlFor="technicalSession">Technical Session</Label>
                  <Input id="technicalSession" name="technicalSession" value={formik.values.technicalSession} onChange={formik.handleChange} onBlur={formik.handleBlur} />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="administrativeSession">Administrative Session</Label>
                  <Input id="administrativeSession" name="administrativeSession" value={formik.values.administrativeSession} onChange={formik.handleChange} onBlur={formik.handleBlur} />
                </div>

                {/* Legacy Row 7: Tender Status | Company Name */}
                <div className="space-y-2">
                  <Label>Tender Status</Label>
                  <Select value={formik.values.tenderStatus || ""} onValueChange={(v) => formik.setFieldValue("tenderStatus", v)}>
                    <SelectTrigger>
                      <SelectValue placeholder="Select Tender Status" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="Open">Open</SelectItem>
                      <SelectItem value="Closed">Closed</SelectItem>
                      <SelectItem value="Pending">Pending</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
                <div className="space-y-2">
                  <Label htmlFor="companyName">Company Name</Label>
                  <Input id="companyName" name="companyName" value={formik.values.companyName} onChange={formik.handleChange} onBlur={formik.handleBlur} />
                </div>

                {/* Legacy Row 8: Contractor Name | Phone No */}
                <div className="space-y-2">
                  <Label htmlFor="contractorName">Contractor Name</Label>
                  <Input id="contractorName" name="contractorName" value={formik.values.contractorName} onChange={formik.handleChange} onBlur={formik.handleBlur} />
                </div>
                <div className="space-y-2">
                  <Label htmlFor="phoneNo">Phone No</Label>
                  <Input id="phoneNo" name="phoneNo" value={formik.values.phoneNo} onChange={formik.handleChange} onBlur={formik.handleBlur} placeholder="10 digits only" className={formik.touched.phoneNo && formik.errors.phoneNo ? "border-red-500" : ""} />
                  {formik.touched.phoneNo && formik.errors.phoneNo && <p className="text-red-500 text-xs">{formik.errors.phoneNo}</p>}
                </div>

                {/* Legacy Row 9: USD Remark */}
                <div className="md:col-span-2 space-y-2">
                  <Label htmlFor="usdRemark">USD Remark</Label>
                  <Textarea id="usdRemark" name="usdRemark" value={formik.values.usdRemark} onChange={formik.handleChange} onBlur={formik.handleBlur} rows={3} placeholder="Enter USD remarks" />
                </div>

                {/* Legacy Row 10: Remark */}
                <div className="md:col-span-2 space-y-2">
                  <Label htmlFor="remarks">Remark</Label>
                  <Textarea id="remarks" name="remarks" value={formik.values.remarks} onChange={formik.handleChange} onBlur={formik.handleBlur} rows={3} placeholder="Enter any additional remarks or notes about the project" />
                </div>
              </div>

              <div className="flex items-center gap-4 mt-10 pt-6 border-t border-gray-200">
                <Button
                  size="lg"
                  type="submit"
                  disabled={loading}
                  className="bg-[#00563B] hover:bg-[#368F8B]"
                >
                  {loading ? "Creating..." : "Create Project"}
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  type="button"
                  onClick={() => router.push("/project-summary")}
                  disabled={loading}
                >
                  Cancel
                </Button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </>
  );
};

export default CreateProject;
