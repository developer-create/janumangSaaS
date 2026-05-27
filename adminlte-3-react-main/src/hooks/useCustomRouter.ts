import { useRouter as useNextRouter } from "next/navigation";
import NProgress from "nprogress";

export const useRouter = () => {
  const router = useNextRouter();

  return {
    ...router,
    push: (href: string, options?: any) => {
      NProgress.start();
      router.push(href, options);
    },
    replace: (href: string, options?: any) => {
      NProgress.start();
      router.replace(href, options);
    },
  };
};
