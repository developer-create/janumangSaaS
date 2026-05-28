"use client";

import dynamic from "next/dynamic";
import { Skeleton } from "@app/components/ui/skeleton";

const CreateSamitiMember = dynamic(
  () => import("@app/views/vidhasabhaSamiti/members/CreateSamitiMember"),
  {
    ssr: false,
    loading: () => (
      <div className="p-6 space-y-4">
        <Skeleton className="h-12 w-full" />
        <Skeleton className="h-64 w-full" />
      </div>
    ),
  }
);

export default function CreateMemberPage({ params }: { params: { id: string } }) {
  return <CreateSamitiMember samitiType="bhagoria-samiti" groupId={params.id} basePath="/vidhasabha-samiti/bhagoria-samiti" />;
}
