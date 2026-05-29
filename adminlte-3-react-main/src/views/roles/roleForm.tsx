"use client";

import { useEffect, useRef, useState } from "react";
import { useFormik } from "formik";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { Button } from "@app/components/ui/button";
import { Input } from "@app/components/ui/input";
import { Checkbox } from "@app/components/ui/checkbox";
import { Label } from "@app/components/ui/label";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@app/components/ui/table";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@app/components/ui/card";
import { Badge } from "@app/components/ui/badge";
import { Skeleton } from "@app/components/ui/skeleton";
import { Loader2, Shield, Package, AlertCircle, Building2 } from "lucide-react";
import { roleSchema, roleInitialValues, IRoleFormValues } from "./role.schema";
import { IPermission } from "@app/types/role";
import { useAppSelector } from "@app/store/store";
import { ITenant } from "@app/types/tenant";

interface RoleFormProps {
  initialValues?: IRoleFormValues;
  onSubmit: (values: IRoleFormValues) => void;
  loading?: boolean;
}

interface ModulePermissions {
  module: string;
  moduleName: string;
  moduleDescription: string;
  permissions: IPermission[];
}

const moduleIcons: Record<string, string> = {
  dashboard: "fas fa-tachometer-alt",
  users: "fas fa-wrench",
  roles: "fas fa-user-shield",
  user_count: "fas fa-chart-pie",
  activity_management: "fas fa-history",
  mp_public_problems: "fas fa-exclamation-circle",
  assembly_issues: "fas fa-university",
  projects: "fas fa-user-friends",
  visitors: "fas fa-id-badge",
  events: "fas fa-calendar-alt",
  members: "fas fa-users",
  voters: "fas fa-id-card",
  phone_directory: "fas fa-address-book",
  departments: "fas fa-building",
  blocks: "fas fa-cubes",
  booths: "fas fa-person-booth",
  panchayats: "fas fa-users",
  villages: "fas fa-home",
  states: "fas fa-map-marker-alt",
  divisions: "fas fa-map-signs",
  districts: "fas fa-map",
  parliaments: "fas fa-landmark",
  assemblies: "fas fa-university",
  samiti: "fas fa-users-cog",
  parties: "fas fa-flag",
  work_types: "fas fa-briefcase",
  sub_work_types: "fas fa-tasks",
  call_management: "fas fa-phone-volume",
  inward_register: "fas fa-file-import",
  dispatch_register: "fas fa-file-export",
};

const RoleForm = ({
  initialValues = roleInitialValues,
  onSubmit,
  loading = false,
}: RoleFormProps) => {
  const [permissionsData, setPermissionsData] = useState<{
    enabledModules: string[];
    permissions: ModulePermissions[];
  } | null>(null);
  const [isLoadingPermissions, setIsLoadingPermissions] = useState(true);
  const [tenants, setTenants] = useState<ITenant[]>([]);
  // useRef so updating guard value doesn't trigger a re-render / re-fetch cycle
  const lastFetchedTenantId = useRef<string | undefined>(undefined);
  const tenantsFetched = useRef(false);
  const currentUserId = useAppSelector((state: any) => state.auth.currentUser?._id);
  const currentUserLevel = useAppSelector((state: any) => state.auth.currentUser?.level);
  const currentUserTenantId = useAppSelector((state: any) => state.auth.currentUser?.tenantId);

  const formik = useFormik<IRoleFormValues>({
    initialValues,
    enableReinitialize: true,
    validationSchema: roleSchema,
    onSubmit: (values) => {
      onSubmit(values);
    },
  });

  // Only true platform admins (no tenantId + system-level) can assign roles to specific orgs
  const isCurrentUserGlobalAdmin =
    !currentUserTenantId &&
    (currentUserLevel === "system_admin" ||
      currentUserLevel === "superadmin");

  useEffect(() => {
    const tenantId = formik.values.tenantId;
    // Only fetch if tenantId actually changed to a different value (use ref to avoid re-renders)
    if (tenantId === lastFetchedTenantId.current) return;
    lastFetchedTenantId.current = tenantId;

    const fetchPermissions = async () => {
      try {
        setIsLoadingPermissions(true);
        const res = await axios.get("/rbac/permissions/available", {
          headers: tenantId
            ? { "x-tenant-id": tenantId }
            : {},
        });
        setPermissionsData(
          res.data.data || { enabledModules: [], permissions: [] },
        );
      } catch (err) {
        console.error("Failed to load permissions", err);
        toast.error("Failed to load available permissions");
      } finally {
        setIsLoadingPermissions(false);
      }
    };
    fetchPermissions();
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [formik.values.tenantId]);

  useEffect(() => {
    if (!isCurrentUserGlobalAdmin || tenantsFetched.current) return;
    tenantsFetched.current = true;
    const fetchTenants = async () => {
      try {
        const res = await axios.get("/tenants?limit=-1");
        if (res.data?.data) {
          setTenants(res.data.data);
        }
      } catch (error) {
        console.error("Failed to fetch tenants:", error);
      }
    };
    fetchTenants();
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [currentUserId, currentUserLevel, currentUserTenantId]);

  const allPermissions =
    permissionsData?.permissions.flatMap((mp) => mp.permissions) || [];

  const toggleModulePermissions = (moduleId: string) => {
    const modulePerms = permissionsData?.permissions.find(
      (mp) => mp.module === moduleId,
    );
    if (!modulePerms) return;

    const permIds = modulePerms.permissions.map((p) => p._id);
    const currentPermissions = [...formik.values.permissions];
    const allPresent = permIds.every((id) => currentPermissions.includes(id));

    if (allPresent) {
      formik.setFieldValue(
        "permissions",
        currentPermissions.filter((id) => !permIds.includes(id)),
      );
    } else {
      formik.setFieldValue("permissions", [
        ...new Set([...currentPermissions, ...permIds]),
      ]);
    }
  };

  const isModuleFullySelected = (moduleId: string) => {
    const modulePerms = permissionsData?.permissions.find(
      (mp) => mp.module === moduleId,
    );
    if (!modulePerms || modulePerms.permissions.length === 0) return false;
    return modulePerms.permissions.every((p) =>
      formik.values.permissions.includes(p._id),
    );
  };

  const isAllTypeSelected = (type: string) => {
    if (!permissionsData || permissionsData.permissions.length === 0) return false;
    
    let totalTypePerms = 0;
    let selectedTypePerms = 0;

    permissionsData.permissions.forEach((mp) => {
      const typePerms = mp.permissions.filter((p) => {
        if (type === "view") return p.name.includes("view") || p.name.includes("list");
        if (type === "other") {
          const name = p.name.toLowerCase();
          return !name.includes("view") && !name.includes("list") && !name.includes("create") && !name.includes("edit") && !name.includes("delete");
        }
        return p.name.includes(type);
      });
      
      totalTypePerms += typePerms.length;
      selectedTypePerms += typePerms.filter(p => formik.values.permissions.includes(p._id)).length;
    });

    return totalTypePerms > 0 && totalTypePerms === selectedTypePerms;
  };

  const toggleAllByType = (type: string) => {
    if (!permissionsData) return;
    
    let allIdsForType: string[] = [];
    permissionsData.permissions.forEach((mp) => {
      const typePerms = mp.permissions.filter((p) => {
        if (type === "view") return p.name.includes("view") || p.name.includes("list");
        if (type === "other") {
          const name = p.name.toLowerCase();
          return !name.includes("view") && !name.includes("list") && !name.includes("create") && !name.includes("edit") && !name.includes("delete");
        }
        return p.name.includes(type);
      });
      allIdsForType = [...allIdsForType, ...typePerms.map(p => p._id)];
    });

    const currentPermissions = [...formik.values.permissions];
    const isAllSelected = allIdsForType.every(id => currentPermissions.includes(id));

    if (isAllSelected) {
      formik.setFieldValue(
        "permissions",
        currentPermissions.filter((id) => !allIdsForType.includes(id)),
      );
    } else {
      formik.setFieldValue("permissions", [
        ...new Set([...currentPermissions, ...allIdsForType]),
      ]);
    }
  };

  const togglePermissionByType = (moduleId: string, type: string) => {
    const modulePerms = permissionsData?.permissions.find(
      (mp) => mp.module === moduleId,
    );
    if (!modulePerms) return;

    const permsToToggle = modulePerms.permissions.filter((p) => {
      if (type === "view")
        return p.name.includes("view") || p.name.includes("list");
      if (type === "other") {
        const name = p.name.toLowerCase();
        return (
          !name.includes("view") &&
          !name.includes("list") &&
          !name.includes("create") &&
          !name.includes("edit") &&
          !name.includes("delete")
        );
      }
      return p.name.includes(type);
    });

    if (permsToToggle.length === 0) return;

    const ids = permsToToggle.map((p) => p._id);
    const currentPermissions = [...formik.values.permissions];
    const allPresent = ids.every((id) => currentPermissions.includes(id));

    if (allPresent) {
      formik.setFieldValue(
        "permissions",
        currentPermissions.filter((id) => !ids.includes(id)),
      );
    } else {
      formik.setFieldValue("permissions", [
        ...new Set([...currentPermissions, ...ids]),
      ]);
    }
  };

  const isPermissionTypeSelected = (moduleId: string, type: string) => {
    const modulePerms = permissionsData?.permissions.find(
      (mp) => mp.module === moduleId,
    );
    if (!modulePerms) return false;

    const permsToCheck = modulePerms.permissions.filter((p) => {
      if (type === "view")
        return p.name.includes("view") || p.name.includes("list");
      if (type === "other") {
        const name = p.name.toLowerCase();
        return (
          !name.includes("view") &&
          !name.includes("list") &&
          !name.includes("create") &&
          !name.includes("edit") &&
          !name.includes("delete")
        );
      }
      return p.name.includes(type);
    });

    if (permsToCheck.length === 0) return false;
    return permsToCheck.every((p) => formik.values.permissions.includes(p._id));
  };

  const hasPermissionType = (moduleId: string, type: string) => {
    const modulePerms = permissionsData?.permissions.find(
      (mp) => mp.module === moduleId,
    );
    if (!modulePerms) return false;

    return modulePerms.permissions.some((p) => {
      if (type === "view")
        return p.name.includes("view") || p.name.includes("list");
      if (type === "other") {
        const name = p.name.toLowerCase();
        return (
          !name.includes("view") &&
          !name.includes("list") &&
          !name.includes("create") &&
          !name.includes("edit") &&
          !name.includes("delete")
        );
      }
      return p.name.includes(type);
    });
  };

  const toggleAllPermissions = () => {
    const allIds = allPermissions.map((p) => p._id);
    const allPresent = allIds.every((id) =>
      formik.values.permissions.includes(id),
    );
    formik.setFieldValue("permissions", allPresent ? [] : allIds);
  };

  const isAllSelected = () => {
    if (allPermissions.length === 0) return false;
    return allPermissions.every((p) =>
      formik.values.permissions.includes(p._id),
    );
  };

  if (isLoadingPermissions) {
    return (
      <div className="p-5 space-y-4">
        <Skeleton className="h-10 w-full" />
        <Skeleton className="h-10 w-full" />
        <Skeleton className="h-64 w-full" />
      </div>
    );
  }

  if (!permissionsData || permissionsData.permissions.length === 0) {
    return (
      <div className="p-5">
        <Card>
          <CardContent className="p-6">
            <div className="flex flex-col items-center justify-center text-center space-y-3">
              <AlertCircle className="h-12 w-12 text-yellow-500" />
              <h3 className="text-lg font-semibold">No Modules Available</h3>
              <p className="text-sm text-gray-600 dark:text-gray-400">
                No modules are enabled for your organization. Please contact
                your administrator.
              </p>
            </div>
          </CardContent>
        </Card>
      </div>
    );
  }

  return (
    <form onSubmit={formik.handleSubmit} className="p-5 space-y-6">
      <Card>
        <CardHeader>
          <CardTitle className="flex items-center gap-2">
            <Shield className="h-5 w-5" />
            Role Information
          </CardTitle>
          <CardDescription>
            Define the basic details for this role
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div className="space-y-2">
              <Label htmlFor="name">Role Name (System) *</Label>
              <Input
                id="name"
                value={formik.values.name}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className={
                  formik.touched.name && formik.errors.name
                    ? "border-red-500"
                    : ""
                }
              />
            </div>
            <div className="space-y-2">
              <Label htmlFor="displayName">Display Name *</Label>
              <Input
                id="displayName"
                value={formik.values.displayName}
                onChange={formik.handleChange}
                onBlur={formik.handleBlur}
                className={
                  formik.touched.displayName && formik.errors.displayName
                    ? "border-red-500"
                    : ""
                }
              />
            </div>
            <div className="md:col-span-2 space-y-2">
              <Label htmlFor="description">Description</Label>
              <Input
                id="description"
                value={formik.values.description}
                onChange={formik.handleChange}
              />
            </div>
            <div className="space-y-2">
              <Label htmlFor="status">Status *</Label>
              <Select
                value={formik.values.status}
                onValueChange={(val) => formik.setFieldValue("status", val)}
              >
                <SelectTrigger
                  className={
                    formik.touched.status && formik.errors.status
                      ? "border-red-500"
                      : ""
                  }
                >
                  <SelectValue placeholder="Select Status" />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value="active">Active</SelectItem>
                  <SelectItem value="inactive">Inactive</SelectItem>
                </SelectContent>
              </Select>
            </div>
            {isCurrentUserGlobalAdmin && (
              <div className="space-y-2">
                <Label htmlFor="tenantId" className="flex items-center gap-2">
                  <Building2 size={16} className="text-[#00563B]" />
                  Target Organization
                </Label>
                <Select
                  value={formik.values.tenantId}
                  onValueChange={(val) => formik.setFieldValue("tenantId", val)}
                >
                  <SelectTrigger>
                    <SelectValue placeholder="Select organization" />
                  </SelectTrigger>
                  <SelectContent>
                    {tenants.map((t) => (
                      <SelectItem key={t._id} value={t._id}>
                        {t.name} ({t.slug})
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>
            )}
          </div>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <div className="flex items-center justify-between">
            <div>
              <CardTitle className="flex items-center gap-2">
                <Package className="h-5 w-5" />
                Permissions
              </CardTitle>
              <CardDescription>
                Select permissions from enabled modules
              </CardDescription>
            </div>
            <Badge variant="secondary">
              {formik.values.permissions.length} selected
            </Badge>
          </div>
        </CardHeader>
        <CardContent>
          <div className="border rounded-lg overflow-x-auto">
            <Table>
              <TableHeader className="bg-[#00563B] text-white">
                <TableRow>
                  <TableHead className="text-white">Module</TableHead>
                  <TableHead className="text-center text-white">
                    <Checkbox
                      checked={isAllSelected()}
                      onCheckedChange={toggleAllPermissions}
                    />
                  </TableHead>
                  <TableHead className="text-center text-white">
                    <div className="flex flex-col items-center gap-1">
                      <span>View</span>
                      <Checkbox
                        checked={isAllTypeSelected("view")}
                        onCheckedChange={() => toggleAllByType("view")}
                        className="border-white data-[state=checked]:bg-white data-[state=checked]:text-[#00563B]"
                      />
                    </div>
                  </TableHead>
                  <TableHead className="text-center text-white">
                    <div className="flex flex-col items-center gap-1">
                      <span>Create</span>
                      <Checkbox
                        checked={isAllTypeSelected("create")}
                        onCheckedChange={() => toggleAllByType("create")}
                        className="border-white data-[state=checked]:bg-white data-[state=checked]:text-[#00563B]"
                      />
                    </div>
                  </TableHead>
                  <TableHead className="text-center text-white">
                    <div className="flex flex-col items-center gap-1">
                      <span>Edit</span>
                      <Checkbox
                        checked={isAllTypeSelected("edit")}
                        onCheckedChange={() => toggleAllByType("edit")}
                        className="border-white data-[state=checked]:bg-white data-[state=checked]:text-[#00563B]"
                      />
                    </div>
                  </TableHead>
                  <TableHead className="text-center text-white">
                    <div className="flex flex-col items-center gap-1">
                      <span>Delete</span>
                      <Checkbox
                        checked={isAllTypeSelected("delete")}
                        onCheckedChange={() => toggleAllByType("delete")}
                        className="border-white data-[state=checked]:bg-white data-[state=checked]:text-[#00563B]"
                      />
                    </div>
                  </TableHead>
                  <TableHead className="text-center text-white">
                    <div className="flex flex-col items-center gap-1">
                      <span>Others</span>
                      <Checkbox
                        checked={isAllTypeSelected("other")}
                        onCheckedChange={() => toggleAllByType("other")}
                        className="border-white data-[state=checked]:bg-white data-[state=checked]:text-[#00563B]"
                      />
                    </div>
                  </TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                {permissionsData.permissions.map((modulePerms) => (
                  <TableRow key={modulePerms.module}>
                    <TableCell>
                      <div className="flex items-center gap-2 font-semibold capitalize">
                        {modulePerms.moduleName}
                      </div>
                    </TableCell>
                    <TableCell className="text-center">
                      <Checkbox
                        checked={isModuleFullySelected(modulePerms.module)}
                        onCheckedChange={() =>
                          toggleModulePermissions(modulePerms.module)
                        }
                      />
                    </TableCell>
                    <TableCell className="text-center">
                      <Checkbox
                        checked={isPermissionTypeSelected(
                          modulePerms.module,
                          "view",
                        )}
                        disabled={
                          !hasPermissionType(modulePerms.module, "view")
                        }
                        onCheckedChange={() =>
                          togglePermissionByType(modulePerms.module, "view")
                        }
                      />
                    </TableCell>
                    <TableCell className="text-center">
                      <Checkbox
                        checked={isPermissionTypeSelected(
                          modulePerms.module,
                          "create",
                        )}
                        disabled={
                          !hasPermissionType(modulePerms.module, "create")
                        }
                        onCheckedChange={() =>
                          togglePermissionByType(modulePerms.module, "create")
                        }
                      />
                    </TableCell>
                    <TableCell className="text-center">
                      <Checkbox
                        checked={isPermissionTypeSelected(
                          modulePerms.module,
                          "edit",
                        )}
                        disabled={
                          !hasPermissionType(modulePerms.module, "edit")
                        }
                        onCheckedChange={() =>
                          togglePermissionByType(modulePerms.module, "edit")
                        }
                      />
                    </TableCell>
                    <TableCell className="text-center">
                      <Checkbox
                        checked={isPermissionTypeSelected(
                          modulePerms.module,
                          "delete",
                        )}
                        disabled={
                          !hasPermissionType(modulePerms.module, "delete")
                        }
                        onCheckedChange={() =>
                          togglePermissionByType(modulePerms.module, "delete")
                        }
                      />
                    </TableCell>
                    <TableCell className="text-center">
                      <Checkbox
                        checked={isPermissionTypeSelected(
                          modulePerms.module,
                          "other",
                        )}
                        disabled={
                          !hasPermissionType(modulePerms.module, "other")
                        }
                        onCheckedChange={() =>
                          togglePermissionByType(modulePerms.module, "other")
                        }
                      />
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </div>
        </CardContent>
      </Card>

      <div className="flex items-center gap-4 pt-4 border-t">
        <Button
          type="submit"
          disabled={loading}
          className="bg-[#00563B] hover:bg-[#2e7a76] min-w-[120px] text-white"
        >
          {loading ? (
            <Loader2 className="mr-2 h-4 w-4 animate-spin" />
          ) : (
            "Save Role"
          )}
        </Button>
        <Button
          type="button"
          variant="outline"
          onClick={() => formik.resetForm()}
        >
          Reset
        </Button>
        <Button
          type="button"
          variant="ghost"
          onClick={() => window.history.back()}
        >
          Cancel
        </Button>
      </div>
    </form>
  );
};

export default RoleForm;
