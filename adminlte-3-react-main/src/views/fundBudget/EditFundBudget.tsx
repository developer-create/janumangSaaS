"use client";

import { useState, useEffect } from "react";
import { useRouter, useParams } from "next/navigation";
import { Button } from "@app/components/ui/button";
import { Input } from "@app/components/ui/input";
import { toast } from "react-toastify";
import { ArrowLeft, Save, LayoutGrid, Loader2 } from "lucide-react";
import api from "@app/utils/axios";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { Label } from "@app/components/ui/label";

export default function EditFundBudget() {
  const router = useRouter();
  const params = useParams();
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [isLoading, setIsLoading] = useState(true);
  const [formData, setFormData] = useState({
    financialYear: "",
    fundKey: "",
    totalAmount: "",
  });

  const fundKeys = [
    { value: "MLA FUND", label: "MLA FUND" },
    { value: "MLA Sweechanudan", label: "Swecha Nidhi (MLA Swechanudan)" },
    { value: "CLP Sweechanudan", label: "CLP Fund (CLP Swechanudan)" },
    { value: "Jansampark Fund", label: "Jansampark Fund" },
  ];

  const years = Array.from({ length: 30 }, (_, i) => {
    const year = 2008 + i;
    return `${year}-${year + 1}`;
  }).reverse();

  useEffect(() => {
    const fetchBudget = async () => {
      try {
        const res = await api.get(`/fund-budgets/${params.id}`);
        setFormData({
          financialYear: res.data.data.financialYear,
          fundKey: res.data.data.fundKey,
          totalAmount: res.data.data.totalAmount.toString(),
        });
      } catch (error) {
        toast.error("Failed to fetch budget details");
        router.push("/fund-budget");
      } finally {
        setIsLoading(false);
      }
    };

    if (params.id) {
      fetchBudget();
    }
  }, [params.id, router]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!formData.financialYear || !formData.fundKey || !formData.totalAmount) {
      toast.error("Please fill in all required fields.");
      return;
    }

    try {
      setIsSubmitting(true);
      await api.put(`/fund-budgets/${params.id}`, {
        ...formData,
        totalAmount: Number(formData.totalAmount),
      });

      toast.success("Fund Budget updated successfully");
      router.push("/fund-budget");
    } catch (error: any) {
      toast.error(
        error.response?.data?.message || "Failed to update fund budget"
      );
    } finally {
      setIsSubmitting(false);
    }
  };

  if (isLoading) {
    return (
      <div className="flex items-center justify-center min-h-screen">
        <Loader2 className="w-8 h-8 animate-spin text-[#368F8B]" />
      </div>
    );
  }

  return (
    <div className="p-4 md:p-8 pt-6 min-h-screen">
      <div className="max-w-3xl mx-auto space-y-6">
        <div className="flex items-center justify-between">
          <div>
            <h1 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
              <LayoutGrid className="w-6 h-6 text-[#368F8B]" />
              Edit Fund Budget
            </h1>
            <p className="text-sm text-gray-500 dark:text-gray-400 mt-1">
              Update the budget allocation.
            </p>
          </div>
          <Button
            variant="outline"
            onClick={() => router.push("/fund-budget")}
            className="hidden md:flex"
          >
            <ArrowLeft className="w-4 h-4 mr-2" />
            Back to List
          </Button>
        </div>

        <div className="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-800">
          <div className="p-6 border-b border-gray-200 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
            <h3 className="text-lg font-semibold text-gray-900 dark:text-white">
              Details
            </h3>
          </div>
          
          <form onSubmit={handleSubmit} className="p-6 space-y-6">
            <div className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="financialYear">
                  Financial Year <span className="text-red-500">*</span>
                </Label>
                <Select
                  value={formData.financialYear}
                  onValueChange={(val: string) =>
                    setFormData({ ...formData, financialYear: val })
                  }
                >
                  <SelectTrigger className="w-full">
                    <SelectValue placeholder="— Select —" />
                  </SelectTrigger>
                  <SelectContent>
                    {years.map((y) => (
                      <SelectItem key={y} value={y}>
                        {y}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>

              <div className="space-y-2">
                <Label htmlFor="fundKey">
                  Fund <span className="text-red-500">*</span>
                </Label>
                <Select
                  value={formData.fundKey}
                  onValueChange={(val: string) =>
                    setFormData({ ...formData, fundKey: val })
                  }
                >
                  <SelectTrigger className="w-full">
                    <SelectValue placeholder="— Select —" />
                  </SelectTrigger>
                  <SelectContent>
                    {fundKeys.map((fk) => (
                      <SelectItem key={fk.value} value={fk.value}>
                        {fk.label}
                      </SelectItem>
                    ))}
                  </SelectContent>
                </Select>
              </div>

              <div className="space-y-2">
                <Label htmlFor="totalAmount">
                  Total Amount (₹) <span className="text-red-500">*</span>
                </Label>
                <Input
                  id="totalAmount"
                  type="number"
                  step="0.01"
                  min="0"
                  placeholder="Enter total amount"
                  value={formData.totalAmount}
                  onChange={(e: React.ChangeEvent<HTMLInputElement>) =>
                    setFormData({ ...formData, totalAmount: e.target.value })
                  }
                  required
                />
              </div>
            </div>

            <div className="pt-6 flex gap-4">
              <Button
                type="submit"
                disabled={isSubmitting}
                className="bg-[#368F8B] hover:bg-[#2A706D] text-white"
              >
                {isSubmitting ? (
                  <span className="flex items-center">
                    <span className="animate-spin mr-2">⏳</span> Updating...
                  </span>
                ) : (
                  <>
                    <Save className="w-4 h-4 mr-2" />
                    Update
                  </>
                )}
              </Button>
              <Button
                type="button"
                variant="outline"
                onClick={() => router.push("/fund-budget")}
                disabled={isSubmitting}
              >
                Cancel
              </Button>
            </div>
          </form>
        </div>
      </div>
    </div>
  );
}
