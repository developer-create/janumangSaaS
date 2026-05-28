"use client";

import { useRouter } from "@app/hooks/useCustomRouter";
import { useState } from "react";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { handleError } from "@app/utils/errorHandler";
import { ContentHeader } from "@app/components";
import SamitiMemberForm from "./SamitiMemberForm";
import { ISamitiMemberFormValues, samitiMemberInitialValues } from "./samitiMember.schema";

interface CreateSamitiMemberProps {
  samitiType: string;
  groupId: string;
  basePath: string;
}

const CreateSamitiMember = ({ samitiType, groupId, basePath }: CreateSamitiMemberProps) => {
  const router = useRouter();
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (values: ISamitiMemberFormValues) => {
    try {
      setLoading(true);
      await axios.post(`/samiti-members/${samitiType}/${groupId}`, values);
      toast.success("Member created successfully!");
      router.push(`${basePath}/${groupId}/members`);
    } catch (error: unknown) {
      handleError(error, "Failed to create member");
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <ContentHeader title="Create Member" />
      <section className="content">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-gray-800 mt-6 p-6">
            <SamitiMemberForm
              initialValues={samitiMemberInitialValues}
              onSubmit={handleSubmit}
              loading={loading}
            />
          </div>
        </div>
      </section>
    </>
  );
};

export default CreateSamitiMember;
