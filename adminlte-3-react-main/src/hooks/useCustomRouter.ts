import { useRouter as useNextRouter } from "next/navigation";
import NProgress from "nprogress";

import { useMemo } from "react";

export const useRouter = () => {
  const router = useNextRouter();

  return useMemo(() => ({
    ...router,
    push: (href: string, options?: any) => {
      NProgress.start();
      router.push(href, options);
    },
    replace: (href: string, options?: any) => {
      NProgress.start();
      router.replace(href, options);
    },
  }), [router]);
};
