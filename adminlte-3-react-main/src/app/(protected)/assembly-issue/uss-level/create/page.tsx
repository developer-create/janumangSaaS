"use client";
import dynamic from "next/dynamic";
import { Skeleton } from "@app/components/ui/skeleton";

const CreateAssemblyIssue = dynamic(
  () => import("@app/views/assemblyIssue/CreateAssemblyIssue"),
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

export default function CreateUSSLevelPage() {
  return (
    <CreateAssemblyIssue
      issueType="uss-level"
      title="Add New USS-Level Issue"
      basePath="/assembly-issue/uss-level"
    />
  );
}
