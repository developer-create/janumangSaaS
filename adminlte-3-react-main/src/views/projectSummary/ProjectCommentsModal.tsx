import { useState, useEffect } from "react";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { Button } from "@app/components/ui/button";
import { Textarea } from "@app/components/ui/textarea";
import { Plus, Loader2 } from "lucide-react";
import { usePermissions } from "@app/hooks/usePermissions";
import { PERMISSIONS } from "@app/config/permissions";
import { useQueryClient } from "@tanstack/react-query";

interface ProjectCommentsModalProps {
  projectId: string;
  isOpen: boolean;
  onClose: () => void;
}

export const ProjectCommentsModal = ({ projectId, isOpen, onClose }: ProjectCommentsModalProps) => {
  const [comments, setComments] = useState<any[]>([]);
  const [newComment, setNewComment] = useState("");
  const [loading, setLoading] = useState(false);
  const [submitting, setSubmitting] = useState(false);
  const { hasPermission } = usePermissions();
  const canAddComment = hasPermission(PERMISSIONS.CREATE_PROJECTS);
  const queryClient = useQueryClient();

  useEffect(() => {
    if (isOpen && projectId) {
      fetchComments();
    }
  }, [isOpen, projectId]);

  const fetchComments = async () => {
    setLoading(true);
    try {
      const res = await axios.get(`/projects/${projectId}/comments`);
      setComments(res.data.data || []);
    } catch (error) {
      toast.error("Failed to fetch comments");
    } finally {
      setLoading(false);
    }
  };

  const handleAddComment = async () => {
    if (!newComment.trim()) return;
    setSubmitting(true);
    try {
      await axios.post(`/projects/${projectId}/comments`, { comment: newComment });
      toast.success("Comment added successfully");
      setNewComment("");
      fetchComments();
      queryClient.invalidateQueries({ queryKey: ["projects"] });
    } catch (error) {
      toast.error("Failed to add comment");
    } finally {
      setSubmitting(false);
    }
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black/60 backdrop-blur-sm z-[2000] flex items-center justify-center p-4" onClick={onClose}>
      <div
        className="bg-white dark:bg-card rounded-xl p-8 max-w-2xl w-full shadow-2xl flex flex-col max-h-[85vh] border border-gray-200 dark:border-gray-800"
        onClick={(e) => e.stopPropagation()}
      >
        <div className="flex justify-between items-center mb-6">
          <h3 className="font-bold text-xl text-gray-900 dark:text-gray-100">Project Comments</h3>
          <button onClick={onClose} className="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <Plus className="w-6 h-6 rotate-45" />
          </button>
        </div>

        <div className="flex-1 overflow-y-auto mb-6 pr-2 space-y-4">
          {loading ? (
            <div className="flex justify-center p-8"><Loader2 className="w-6 h-6 animate-spin text-gray-400" /></div>
          ) : comments.length === 0 ? (
            <p className="text-center text-gray-500 py-8">No comments found.</p>
          ) : (
            comments.map((comment) => (
              <div key={comment._id} className="bg-gray-50 dark:bg-gray-800/50 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                <p className="text-gray-800 dark:text-gray-200 whitespace-pre-wrap">{comment.comment}</p>
                <div className="flex justify-between mt-2 text-xs text-gray-500 dark:text-gray-400">
                  <span>{comment.createdBy?.name || "Unknown User"}</span>
                  <span>{new Date(comment.createdAt).toLocaleString()}</span>
                </div>
              </div>
            ))
          )}
        </div>

        {canAddComment && (
          <div className="mt-auto border-t pt-4 border-gray-200 dark:border-gray-700">
            <Textarea
              placeholder="Type your comment here..."
              value={newComment}
              onChange={(e) => setNewComment(e.target.value)}
              className="mb-4"
              rows={3}
            />
            <div className="flex justify-end gap-3">
              <Button variant="outline" onClick={onClose}>Cancel</Button>
              <Button
                onClick={handleAddComment}
                disabled={submitting || !newComment.trim()}
                className="bg-[#368F8B] hover:bg-[#2d7a76]"
              >
                {submitting ? "Adding..." : "Add Comment"}
              </Button>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};
