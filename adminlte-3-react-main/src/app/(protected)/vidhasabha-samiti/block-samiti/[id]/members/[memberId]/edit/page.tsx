"use client";

import dynamic from "next/dynamic";
import { Skeleton } from "@app/components/ui/skeleton";

const EditSamitiMember = dynamic(
  () => import("@app/views/vidhasabhaSamiti/members/EditSamitiMember"),
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

export default function EditMemberPage({ params }: { params: { id: string; memberId: string } }) {
  return <EditSamitiMember memberId={params.memberId} groupId={params.id} basePath="/vidhasabha-samiti/block-samiti" />;
}
