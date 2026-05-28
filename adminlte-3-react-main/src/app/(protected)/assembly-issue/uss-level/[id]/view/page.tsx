"use client";
import dynamic from "next/dynamic";
import { Skeleton } from "@app/components/ui/skeleton";

const ViewAssemblyIssue = dynamic(
  () => import("@app/views/assemblyIssue/ViewAssemblyIssue"),
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

export default function ViewUSSLevelPage() {
  return (
    <ViewAssemblyIssue
      issueType="uss-level"
      title="View USS-Level Issue"
      basePath="/assembly-issue/uss-level"
    />
  );
}
