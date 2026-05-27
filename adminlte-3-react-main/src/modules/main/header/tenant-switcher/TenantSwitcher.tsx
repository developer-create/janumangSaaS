"use client";

import { useQuery } from "@tanstack/react-query";
import axios from "@app/utils/axios";
import { useAppSelector } from "@app/store/store";
import { useState, useEffect } from "react";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { Building2, Globe } from "lucide-react";
import { ITenant } from "@app/types/tenant";

const TenantSwitcher = () => {
  const currentUser = useAppSelector((state) => state.auth.currentUser);
  const [selectedTenant, setSelectedTenant] = useState<string>("default");

  // SECURITY: Only true platform admins (no tenantId + system-level) can switch tenants
  const isGlobalAdmin =
    !currentUser?.tenantId &&
    (currentUser?.level === "system_admin" ||
      currentUser?.level === "superadmin");

  const { data: tenants = [], isFetched } = useQuery({
    queryKey: ["tenants-list"],
    queryFn: async () => {
      const res = await axios.get("/tenants?limit=-1");
      return res.data?.data || [];
    },
    enabled: !!isGlobalAdmin,
  });

  useEffect(() => {
    if (!isFetched) return; // Prevent clearing localStorage before tenants load

    const saved = localStorage.getItem("overrideTenantId");
    if (saved) {
      // Validate that the saved tenant actually exists
      const tenantExists = tenants.some((t: ITenant) => t._id === saved);
      if (tenantExists) {
        setSelectedTenant(saved);
      } else {
        // Tenant doesn't exist, clear it
        localStorage.removeItem("overrideTenantId");
        setSelectedTenant("default");
      }
    }
  }, [tenants, isFetched]);

  const handleSwitch = (value: string) => {
    setSelectedTenant(value);
    if (value === "default") {
      localStorage.removeItem("overrideTenantId");
    } else {
      localStorage.setItem("overrideTenantId", value);
    }
    // Refresh the page to apply new tenant context across all queries
    window.location.reload();
  };

  if (!isGlobalAdmin) return null;

  return (
    <div className="flex items-center gap-2 mr-4">
      <Select value={selectedTenant} onValueChange={handleSwitch}>
        <SelectTrigger className="w-[200px] h-9 bg-gray-50/50 dark:bg-gray-800/50 border-gray-200 dark:border-gray-700 text-xs font-semibold">
          <div className="flex items-center gap-2">
            <Building2 size={14} className="text-[#368F8B]" />
            <SelectValue placeholder="Select Organization" />
          </div>
        </SelectTrigger>
        <SelectContent>
          <SelectItem value="default" className="text-xs">
            <div className="flex items-center gap-2">
              <Globe size={14} />
              My Default Org
            </div>
          </SelectItem>
          {tenants.map((tenant: ITenant) => (
            <SelectItem key={tenant._id} value={tenant._id} className="text-xs">
              {tenant.name}
            </SelectItem>
          ))}
        </SelectContent>
      </Select>
    </div>
  );
};

export default TenantSwitcher;
