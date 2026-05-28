"use client";

import dynamic from "next/dynamic";
import { Skeleton } from "@app/components/ui/skeleton";

const SamitiMemberList = dynamic(
  () => import("@app/views/vidhasabhaSamiti/members/SamitiMemberList"),
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

export default function MembersPage({ params }: { params: { id: string } }) {
  return <SamitiMemberList samitiType="mandir-samiti" groupId={params.id} basePath="/vidhasabha-samiti/mandir-samiti" />;
}
