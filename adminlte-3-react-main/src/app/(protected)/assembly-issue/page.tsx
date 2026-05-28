"use client";
import { useEffect } from "react";
import { useRouter } from "next/navigation";

export default function AssemblyIssuePage() {
  const router = useRouter();
  useEffect(() => {
    router.replace("/assembly-issue/block-level");
  }, [router]);
  return null;
}
