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

export default function EditBlockLevelPage() {
  return (
    <EditAssemblyIssue
      issueType="block-level"
      title="Edit Block-Level Issue"
      basePath="/assembly-issue/block-level"
    />
  );
}
