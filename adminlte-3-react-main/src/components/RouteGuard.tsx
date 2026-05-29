"use client";

import { useEffect, useRef } from "react";
import { useRouter } from "@app/hooks/useCustomRouter";
import { usePathname } from "next/navigation";
import { usePermissions } from "@app/hooks/usePermissions";

import { Permission } from "@app/config/permissions";

interface RouteGuardProps {
  children: React.ReactNode;
  requiredPermission?: Permission | string;
  requiredPermissions?: (Permission | string)[];
  requireAll?: boolean; // If true, user must have ALL permissions. If false, ANY permission is enough
  redirectTo?: string;
  checkSidebarAccess?: boolean; // Optional: check sidebar access (default: false)
}

import { toast } from "react-toastify";
import { MENU } from "@app/utils/menu";

// ... (existing imports)

export const RouteGuard = ({
  children,
  requiredPermission,
  requiredPermissions,
  requireAll = false,
  redirectTo = "/dashboard",
  checkSidebarAccess = false,
}: RouteGuardProps) => {
  const router = useRouter();
  const pathname = usePathname();
  const {
    hasPermission,
    hasAnyPermission,
    hasAllPermissions,
    hasSidebarAccess,
    user,
  } = usePermissions();

  // Use ref to avoid re-running effect when router/callback references change
  const routerRef = useRef(router);
  routerRef.current = router;

  const hasPermissionRef = useRef(hasPermission);
  hasPermissionRef.current = hasPermission;
  const hasAnyPermissionRef = useRef(hasAnyPermission);
  hasAnyPermissionRef.current = hasAnyPermission;
  const hasAllPermissionsRef = useRef(hasAllPermissions);
  hasAllPermissionsRef.current = hasAllPermissions;
  const hasSidebarAccessRef = useRef(hasSidebarAccess);
  hasSidebarAccessRef.current = hasSidebarAccess;

  // Stable string identity for MENU access path
  const getFirstAccessiblePath = () => {
    for (const item of MENU) {
      if (item.path) {
        let hasAccess = false;

        // 1. Check Role Match
        const roleName = typeof user?.role === "string" ? "" : user?.role?.name;
        if (item.allowedRoles && item.allowedRoles.length > 0) {
          if (item.allowedRoles.includes(roleName || "")) {
            hasAccess = true;
          }
        }

        // 2. Check Permission Match
        if (
          !hasAccess &&
          item.allowedPermissions &&
          item.allowedPermissions.length > 0
        ) {
          if (hasAnyPermissionRef.current(item.allowedPermissions)) {
            hasAccess = true;
          }
        }

        // 3. Public Item
        if (
          (!item.allowedRoles || item.allowedRoles.length === 0) &&
          (!item.allowedPermissions || item.allowedPermissions.length === 0)
        ) {
          hasAccess = true;
        }

        // 4. Resource Check
        if (!hasAccess && item.resource) {
          const viewPermission = `view_${item.resource}`;
          if (hasPermissionRef.current(viewPermission)) {
            hasAccess = true;
          }
        }

        if (hasAccess) {
          return item.path;
        }
      }
    }
    return "/no-permission";
  };

  useEffect(() => {
    if (!user) {
      routerRef.current.push("/login");
      return;
    }

    let hasAccess = true;

    // Optional: Check sidebar access
    if (checkSidebarAccess && !hasSidebarAccessRef.current(pathname)) {
      hasAccess = false;
    }

    // Check specific permission
    if (hasAccess && requiredPermission && !hasPermissionRef.current(requiredPermission)) {
      hasAccess = false;
    }

    // Check multiple permissions
    if (hasAccess && requiredPermissions && requiredPermissions.length > 0) {
      hasAccess = requireAll
        ? hasAllPermissionsRef.current(requiredPermissions)
        : hasAnyPermissionRef.current(requiredPermissions);
    }

    if (!hasAccess) {
      const fallbackPath = getFirstAccessiblePath();
      if (fallbackPath !== pathname) {
        toast.error("Permission Denied: Redirecting to authorized module...");
        routerRef.current.push(fallbackPath);
      }
      return;
    }
  // Only re-run when the actual stable data changes: user identity, pathname, permission requirements
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [
    user?._id,
    user?.level,
    user?.tenantId,
    pathname,
    requiredPermission,
    // eslint-disable-next-line react-hooks/exhaustive-deps
    JSON.stringify(requiredPermissions),
    requireAll,
    checkSidebarAccess,
  ]);

  // Show nothing while checking permissions or redirecting
  if (!user) return null;

  // Re-check for rendering (same logic as effect)
  let hasAccess = true;
  if (checkSidebarAccess && !hasSidebarAccess(pathname)) hasAccess = false;
  if (hasAccess && requiredPermission && !hasPermission(requiredPermission))
    hasAccess = false;
  if (hasAccess && requiredPermissions && requiredPermissions.length > 0) {
    hasAccess = requireAll
      ? hasAllPermissions(requiredPermissions)
      : hasAnyPermission(requiredPermissions);
  }

  if (!hasAccess) {
    return null;
  }

  return <>{children}</>;
};
