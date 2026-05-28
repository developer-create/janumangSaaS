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

export default function CreateBhopalLevelPage() {
  return (
    <CreateAssemblyIssue
      issueType="bhopal-level"
      title="Add New Bhopal-Level Issue"
      basePath="/assembly-issue/bhopal-level"
    />
  );
}
