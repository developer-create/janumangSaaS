"use client";

import { useState } from "react";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { ContentHeader } from "@app/components";
import { RouteGuard } from "@app/components/RouteGuard";
import { PERMISSIONS } from "@app/config/permissions";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@app/components/ui/table";
import { Button } from "@app/components/ui/button";
import { Loader2, Check, X } from "lucide-react";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { IEvent } from "@app/types/events";

const Approvals = () => {
  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.EDIT_EVENTS]}>
      <ApprovalsContent />
    </RouteGuard>
  );
};

const ApprovalsContent = () => {
  const queryClient = useQueryClient();
  const [rejectingId, setRejectingId] = useState<string | null>(null);
  const [rejectionReason, setRejectionReason] = useState("");

  const { data: response, isLoading } = useQuery<{ data: IEvent[] }>({
    queryKey: ["events", "pending"],
    queryFn: async () => {
      const { data } = await axios.get("/events/pending");
      return data;
    },
  });

  const approveMutation = useMutation({
    mutationFn: async (id: string) => {
      await axios.post(`/events/${id}/approve`);
    },
    onSuccess: () => {
      toast.success("Event approved successfully");
      queryClient.invalidateQueries({ queryKey: ["events", "pending"] });
    },
    onError: () => toast.error("Failed to approve event"),
  });

  const rejectMutation = useMutation({
    mutationFn: async ({ id, reason }: { id: string; reason: string }) => {
      await axios.post(`/events/${id}/reject`, { reason });
    },
    onSuccess: () => {
      toast.success("Event rejected successfully");
      setRejectingId(null);
      setRejectionReason("");
      queryClient.invalidateQueries({ queryKey: ["events", "pending"] });
    },
    onError: () => toast.error("Failed to reject event"),
  });

  const events = response?.data || [];

  return (
    <>
      <ContentHeader title="Event Approvals" />
      <section className="content">
        <div className="container-fluid px-4">
          <div className="bg-white dark:bg-card rounded-xl shadow-lg border border-gray-200 dark:border-none mt-6 overflow-hidden p-6">
            <h2 className="text-xl font-bold mb-4">Pending Events</h2>
            <div className="overflow-x-auto">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Unique ID</TableHead>
                    <TableHead>Name</TableHead>
                    <TableHead>Event Type</TableHead>
                    <TableHead>District</TableHead>
                    <TableHead>Program Date</TableHead>
                    <TableHead className="text-right">Actions</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {isLoading ? (
                    <TableRow>
                      <TableCell colSpan={6} className="text-center py-10">
                        <Loader2 className="w-6 h-6 animate-spin mx-auto text-gray-400" />
                      </TableCell>
                    </TableRow>
                  ) : events.length === 0 ? (
                    <TableRow>
                      <TableCell colSpan={6} className="text-center py-10">
                        No pending events found
                      </TableCell>
                    </TableRow>
                  ) : (
                    events.map((event) => (
                      <TableRow key={event._id}>
                        <TableCell className="font-bold">
                          {event.uniqueId}
                        </TableCell>
                        <TableCell>{event.name}</TableCell>
                        <TableCell>{event.eventType}</TableCell>
                        <TableCell>{event.district}</TableCell>
                        <TableCell>
                          {new Date(event.programDate).toLocaleDateString()}
                        </TableCell>
                        <TableCell className="text-right">
                          {rejectingId === event._id ? (
                            <div className="flex items-center gap-2 justify-end">
                              <input
                                type="text"
                                placeholder="Rejection reason..."
                                className="border rounded px-2 py-1 text-sm dark:bg-gray-800 dark:border-gray-700"
                                value={rejectionReason}
                                onChange={(e) =>
                                  setRejectionReason(e.target.value)
                                }
                              />
                              <Button
                                size="sm"
                                variant="destructive"
                                onClick={() =>
                                  rejectMutation.mutate({
                                    id: event._id,
                                    reason: rejectionReason,
                                  })
                                }
                                disabled={rejectMutation.isPending}
                              >
                                Confirm Reject
                              </Button>
                              <Button
                                size="sm"
                                variant="outline"
                                onClick={() => {
                                  setRejectingId(null);
                                  setRejectionReason("");
                                }}
                              >
                                Cancel
                              </Button>
                            </div>
                          ) : (
                            <div className="flex justify-end gap-2">
                              <Button
                                size="sm"
                                className="bg-green-600 hover:bg-green-700 text-white"
                                onClick={() => approveMutation.mutate(event._id)}
                                disabled={approveMutation.isPending}
                              >
                                <Check className="w-4 h-4 mr-1" /> Approve
                              </Button>
                              <Button
                                size="sm"
                                variant="destructive"
                                onClick={() => setRejectingId(event._id)}
                              >
                                <X className="w-4 h-4 mr-1" /> Reject
                              </Button>
                            </div>
                          )}
                        </TableCell>
                      </TableRow>
                    ))
                  )}
                </TableBody>
              </Table>
            </div>
          </div>
        </div>
      </section>
    </>
  );
};

export default Approvals;
