"use client";

import { useRouter } from "@app/hooks/useCustomRouter";
import { useState } from "react";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { handleError } from "@app/utils/errorHandler";
import { ContentHeader } from "@app/components";
import SamitiMemberForm from "./SamitiMemberForm";
import { useQuery } from "@tanstack/react-query";
import { ISamitiMemberFormValues } from "./samitiMember.schema";
import { Skeleton } from "@app/components/ui/skeleton";

interface EditSamitiMemberProps {
  memberId: string;
  groupId: string;
  basePath: string;
}

const EditSamitiMember = ({ memberId, groupId, basePath }: EditSamitiMemberProps) => {
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const { data: response, isLoading, isError } = useQuery({
    queryKey: ["samiti-member", memberId],
    queryFn: async () => {
      const { data } = await axios.get(`/samiti-members/${memberId}`);
      return data;
    },
  });

  const handleSubmit = async (values: ISamitiMemberFormValues) => {
    try {
      setLoading(true);
      await axios.put(`/samiti-members/${memberId}`, values);
      toast.success("Member updated successfully!");
      router.push(`${basePath}/${groupId}/members`);
    } catch (error: unknown) {
      handleError(error, "Failed to update member");
    } finally {
      setLoading(false);
    }
  };

  if (isLoading) {
    return (
      <>
        <ContentHeader title="Edit Member" />
        <section className="content">
          <div className="container-fluid px-4">
            <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 mt-6 p-6 space-y-4">
              <Skeleton className="h-10 w-full max-w-md" />
              <Skeleton className="h-10 w-full max-w-md" />
              <Skeleton className="h-10 w-full max-w-md" />
            </div>
          </div>
        </section>
      </>
    );
  }

  if (isError || !response?.data) {
    return (
      <div className="p-6 text-center text-red-500">
        Failed to load member details.
      </div>
    );
  }

  const memberData = response.data;
  const initialValues: ISamitiMemberFormValues = {
    memberName: memberData.memberName || "",
    fatherName: memberData.fatherName || "",
    age: memberData.age || "",
    position: memberData.position || "",
    mobileNumber: memberData.mobileNumber || "",
    remark: memberData.remark || "",
  };

  return (
    <>
      <ContentHeader title="Edit Member" />
      <section className="content">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 mt-6 p-6">
            <SamitiMemberForm
              initialValues={initialValues}
              onSubmit={handleSubmit}
              loading={loading}
            />
          </div>
        </div>
      </section>
    </>
  );
};

export default EditSamitiMember;
