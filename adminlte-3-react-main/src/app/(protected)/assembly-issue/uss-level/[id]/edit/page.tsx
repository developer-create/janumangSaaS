"use client";
import dynamic from "next/dynamic";
import { Skeleton } from "@app/components/ui/skeleton";

const EditAssemblyIssue = dynamic(
  () => import("@app/views/assemblyIssue/EditAssemblyIssue"),
  {
    ssr: false,
    loading: () => (
      <div className="p-6 space-y-4">
        <Skeleton className="h-12 w-full" />
        <Skeleton className="h-[401px] w-full" />
      </div>
    ),
  }
);

export default function EditUSSLevelPage() {
  return (
    <EditAssemblyIssue
      issueType="uss-level"
      title="Edit USS-Level Issue"
      basePath="/assembly-issue/uss-level"
    />
  );
}
