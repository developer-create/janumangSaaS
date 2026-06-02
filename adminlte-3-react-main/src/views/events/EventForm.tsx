"use client";

import { useEffect, useState } from "react";
import { useFormik } from "formik";
import { useRouter } from "@app/hooks/useCustomRouter";
import { useQuery } from "@tanstack/react-query";
import axios from "@app/utils/axios";

import { Button } from "@app/components/ui/button";
import { Input } from "@app/components/ui/input";
import { Label } from "@app/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@app/components/ui/select";
import { Textarea } from "@app/components/ui/textarea";
import { Loader2 } from "lucide-react";
import {
  eventSchema,
  eventInitialValues,
  IEventFormValues,
} from "./event.schema";

interface EventFormProps {
  initialValues?: IEventFormValues;
  onSubmit: (values: IEventFormValues) => void;
  loading?: boolean;
}

const EventForm = ({
  initialValues = eventInitialValues,
  onSubmit,
  loading = false,
}: EventFormProps) => {
  const router = useRouter();

  const { data: districtsResponse } = useQuery({
    queryKey: ["districts-all"],
    queryFn: async () => {
      const { data } = await axios.get("/districts?limit=1000");
      return data;
    },
  });

  const { data: blocksResponse } = useQuery({
    queryKey: ["blocks-all"],
    queryFn: async () => {
      const { data } = await axios.get("/blocks?limit=1000");
      return data;
    },
  });

  const districtsList = districtsResponse?.data || [];
  const blocksList = blocksResponse?.data || [];

  const formik = useFormik<IEventFormValues>({
    initialValues,
    enableReinitialize: true,
    validationSchema: eventSchema,
    onSubmit: (values) => {
      onSubmit(values);
    },
  });

  // Auto populate Day, Month, Year from programDate
  useEffect(() => {
    if (formik.values.programDate) {
      const date = new Date(formik.values.programDate);
      if (!isNaN(date.getTime())) {
        const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        const dayName = dayNames[date.getDay()];
        const monthName = monthNames[date.getMonth()];
        const year = date.getFullYear().toString();

        if ((formik.values as any).day !== dayName) formik.setFieldValue("day", dayName);
        if ((formik.values as any).month !== monthName) formik.setFieldValue("month", monthName);
        if ((formik.values as any).year !== year) formik.setFieldValue("year", year);
      }
    }
  }, [formik.values.programDate]);

  return (
    <form onSubmit={formik.handleSubmit} className="space-y-8">
      {/* Invitation Details Section */}
      <div>
        <h4 className="bg-[#3c8dbc] text-white p-2.5 mb-5 rounded-md">Invitation Received Details</h4>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div className="space-y-2">
            <Label htmlFor="receivingDate">Invitation Date <span className="text-red-500">*</span></Label>
            <Input
              id="receivingDate"
              type="date"
              name="receivingDate"
              value={formik.values.receivingDate ? new Date(formik.values.receivingDate).toISOString().split('T')[0] : ''}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              className={formik.touched.receivingDate && formik.errors.receivingDate ? "border-red-500" : ""}
            />
            {formik.touched.receivingDate && formik.errors.receivingDate && (
              <p className="text-red-500 text-sm">{formik.errors.receivingDate}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="office">Invitation Received Office <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("office", val)} value={formik.values.office || ""}>
              <SelectTrigger className={formik.touched.office && formik.errors.office ? "border-red-500" : ""}>
                <SelectValue placeholder="Select Office" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="Bhopal">Bhopal</SelectItem>
                <SelectItem value="Dhar">Dhar</SelectItem>
                <SelectItem value="Gandhwani">Gandhwani</SelectItem>
                <SelectItem value="Tanda">Tanda</SelectItem>
                <SelectItem value="Bagh">Bagh</SelectItem>
              </SelectContent>
            </Select>
            {formik.touched.office && formik.errors.office && (
              <p className="text-red-500 text-sm">{formik.errors.office}</p>
            )}
          </div>
        </div>
      </div>

      {/* Event Details Section */}
      <div>
        <h4 className="bg-[#3c8dbc] text-white p-2.5 mb-5 rounded-md mt-8">Event Details</h4>
        <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
          <div className="space-y-2">
            <Label htmlFor="programDate">Event Program Date <span className="text-red-500">*</span></Label>
            <Input
              id="programDate"
              type="date"
              name="programDate"
              value={formik.values.programDate ? new Date(formik.values.programDate).toISOString().split('T')[0] : ''}
              onChange={formik.handleChange}
              onBlur={formik.handleBlur}
              className={formik.touched.programDate && formik.errors.programDate ? "border-red-500" : ""}
            />
            {formik.touched.programDate && formik.errors.programDate && (
              <p className="text-red-500 text-sm">{formik.errors.programDate}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="day">Event Day</Label>
            <Select onValueChange={(val) => formik.setFieldValue("day", val)} value={(formik.values as any).day || ""}>
              <SelectTrigger>
                <SelectValue placeholder="-- Select Day --" />
              </SelectTrigger>
              <SelectContent>
                {["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"].map((d) => (
                  <SelectItem key={d} value={d}>{d}</SelectItem>
                ))}
              </SelectContent>
            </Select>
          </div>
          <div className="space-y-2">
            <Label htmlFor="month">Event Month <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("month", val)} value={(formik.values as any).month || ""}>
              <SelectTrigger className={formik.touched.month && formik.errors.month ? "border-red-500" : ""}>
                <SelectValue placeholder="Select Month" />
              </SelectTrigger>
              <SelectContent>
                {['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'].map(m => (
                  <SelectItem key={m} value={m}>{m}</SelectItem>
                ))}
              </SelectContent>
            </Select>
            {formik.touched.month && formik.errors.month && (
              <p className="text-red-500 text-sm">{formik.errors.month}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="year">Event Year <span className="text-red-500">*</span></Label>
            <Input id="year" type="number" {...formik.getFieldProps("year")} className={formik.touched.year && formik.errors.year ? "border-red-500" : ""} />
            {formik.touched.year && formik.errors.year && (
              <p className="text-red-500 text-sm">{formik.errors.year}</p>
            )}
          </div>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
          <div className="space-y-2">
            <Label htmlFor="eventType">Event Type <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("eventType", val)} value={formik.values.eventType || ""}>
              <SelectTrigger className={formik.touched.eventType && formik.errors.eventType ? "border-red-500" : ""}>
                <SelectValue placeholder="Select Event Type" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="Social Events">Social Events</SelectItem>
                <SelectItem value="Sports Events">Sports Events</SelectItem>
                <SelectItem value="Religious Events">Religious Events</SelectItem>
                <SelectItem value="Professional Events">Professional Events</SelectItem>
                <SelectItem value="Condolence Journal">Condolence Journal</SelectItem>
              </SelectContent>
            </Select>
            {formik.touched.eventType && formik.errors.eventType && (
              <p className="text-red-500 text-sm">{formik.errors.eventType}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="time">Event Time <span className="text-red-500">*</span></Label>
            <Input id="time" type="time" {...formik.getFieldProps("time")} className={formik.touched.time && formik.errors.time ? "border-red-500" : ""} />
            {formik.touched.time && formik.errors.time && (
              <p className="text-red-500 text-sm">{formik.errors.time}</p>
            )}
          </div>
        </div>
      </div>

      {/* Program Details Section */}
      <div>
        <h4 className="bg-[#3c8dbc] text-white p-2.5 mb-5 rounded-md mt-8">Program Details</h4>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="space-y-2">
            <Label htmlFor="eventDetails">Event (Name) Details <span className="text-red-500">*</span></Label>
            <Input id="eventDetails" {...formik.getFieldProps("eventDetails")} className={formik.touched.eventDetails && formik.errors.eventDetails ? "border-red-500" : ""} />
            {formik.touched.eventDetails && formik.errors.eventDetails && (
              <p className="text-red-500 text-sm">{formik.errors.eventDetails}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="block">Block <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("block", val)} value={formik.values.block || ""}>
              <SelectTrigger className={formik.touched.block && formik.errors.block ? "border-red-500" : ""}>
                <SelectValue placeholder="Select Block" />
              </SelectTrigger>
              <SelectContent>
                {blocksList.map((b: any) => (
                  <SelectItem key={b._id} value={b._id}>{b.name}</SelectItem>
                ))}
              </SelectContent>
            </Select>
            {formik.touched.block && formik.errors.block && (
              <p className="text-red-500 text-sm">{formik.errors.block}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="district">District <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("district", val)} value={formik.values.district || ""}>
              <SelectTrigger className={formik.touched.district && formik.errors.district ? "border-red-500" : ""}>
                <SelectValue placeholder="Select District" />
              </SelectTrigger>
              <SelectContent>
                {districtsList.map((d: any) => (
                  <SelectItem key={d._id || d.name} value={d.name}>{d.name}</SelectItem>
                ))}
                <SelectItem value="other">Other</SelectItem>
              </SelectContent>
            </Select>
            {formik.touched.district && formik.errors.district && (
              <p className="text-red-500 text-sm">{formik.errors.district}</p>
            )}
          </div>
        </div>

        {formik.values.district === 'other' && (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <div className="md:col-start-3 space-y-2">
              <Label htmlFor="otherDistrictName">Enter District Name <span className="text-red-500">*</span></Label>
              <Input 
                id="otherDistrictName" 
                {...formik.getFieldProps("otherDistrictName")}
                placeholder="Enter new district name" 
                className={formik.touched.otherDistrictName && formik.errors.otherDistrictName ? "border-red-500" : ""}
              />
              {formik.touched.otherDistrictName && formik.errors.otherDistrictName && (
                <p className="text-red-500 text-sm">{formik.errors.otherDistrictName}</p>
              )}
            </div>
          </div>
        )}

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
          <div className="space-y-2">
            <Label htmlFor="venueCity">Venue City <span className="text-red-500">*</span></Label>
            <Input id="venueCity" {...formik.getFieldProps("venueCity")} className={formik.touched.venueCity && formik.errors.venueCity ? "border-red-500" : ""} />
            {formik.touched.venueCity && formik.errors.venueCity && (
              <p className="text-red-500 text-sm">{formik.errors.venueCity}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="referencePerson">Reference Person Name/Post <span className="text-red-500">*</span></Label>
            <Input id="referencePerson" {...formik.getFieldProps("referencePerson")} className={formik.touched.referencePerson && formik.errors.referencePerson ? "border-red-500" : ""} />
            {formik.touched.referencePerson && formik.errors.referencePerson && (
              <p className="text-red-500 text-sm">{formik.errors.referencePerson}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="contactNumber">Contact Number <span className="text-red-500">*</span></Label>
            <Input id="contactNumber" type="number" {...formik.getFieldProps("contactNumber")} className={formik.touched.contactNumber && formik.errors.contactNumber ? "border-red-500" : ""} />
            {formik.touched.contactNumber && formik.errors.contactNumber && (
              <p className="text-red-500 text-sm">{formik.errors.contactNumber}</p>
            )}
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
          <div className="space-y-2">
            <Label htmlFor="address">Address <span className="text-red-500">*</span></Label>
            <Textarea id="address" {...formik.getFieldProps("address")} className={`h-10 ${formik.touched.address && formik.errors.address ? "border-red-500" : ""}`} />
            {formik.touched.address && formik.errors.address && (
              <p className="text-red-500 text-sm">{formik.errors.address}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="name">Name <span className="text-red-500">*</span></Label>
            <Input id="name" {...formik.getFieldProps("name")} className={formik.touched.name && formik.errors.name ? "border-red-500" : ""} />
            {formik.touched.name && formik.errors.name && (
              <p className="text-red-500 text-sm">{formik.errors.name}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="location">Location <span className="text-red-500">*</span></Label>
            <Input id="location" {...formik.getFieldProps("location")} className={formik.touched.location && formik.errors.location ? "border-red-500" : ""} />
            {formik.touched.location && formik.errors.location && (
              <p className="text-red-500 text-sm">{formik.errors.location}</p>
            )}
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
          <div className="space-y-2">
            <Label htmlFor="priority">Priority</Label>
            <Select onValueChange={(val) => formik.setFieldValue("priority", val)} value={formik.values.priority || ""}>
              <SelectTrigger>
                <SelectValue placeholder="Select Priority" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="High">High</SelectItem>
                <SelectItem value="Medium">Medium</SelectItem>
                <SelectItem value="Low">Low</SelectItem>
              </SelectContent>
            </Select>
          </div>
          <div className="space-y-2">
            <Label htmlFor="probability">PROBABILITY (JANA KI NAHI JANA) <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("probability", val)} value={formik.values.probability || ""}>
              <SelectTrigger className={formik.touched.probability && formik.errors.probability ? "border-red-500" : ""}>
                <SelectValue placeholder="Select Option" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="जाना है">जाना हैं</SelectItem>
                <SelectItem value="नही जाना है">नही जाना हैं</SelectItem>
                <SelectItem value="जानकारी नही है">जानकारी नही हैं</SelectItem>
              </SelectContent>
            </Select>
            {formik.touched.probability && formik.errors.probability && (
              <p className="text-red-500 text-sm">{formik.errors.probability}</p>
            )}
          </div>
          <div className="space-y-2">
            <Label htmlFor="duration">TENTATIVE DURATION</Label>
            <Input id="duration" {...formik.getFieldProps("duration")} />
          </div>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
          <div className="space-y-2">
            <Label htmlFor="attended">ATTENDED (YES/NO) <span className="text-red-500">*</span></Label>
            <Select onValueChange={(val) => formik.setFieldValue("attended", val)} value={formik.values.attended || ""}>
              <SelectTrigger>
                <SelectValue placeholder="-- Select Option --" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="YES">YES</SelectItem>
                <SelectItem value="NO">NO</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </div>
        
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
          <div className="space-y-2">
            <Label htmlFor="pressConference">Press Conference <span className="text-red-500">*</span></Label>
            <Input id="pressConference" {...formik.getFieldProps("pressConference")} />
          </div>
        </div>

        {formik.values.attended === "NO" && (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-md">
            <div className="space-y-2">
              <Label htmlFor="dispatchDate">DISPATCH DATE (IF NOT ATTENDED)</Label>
              <Input id="dispatchDate" type="date" {...formik.getFieldProps("dispatchDate")} />
            </div>
            <div className="space-y-2">
              <Label htmlFor="dispatchNumber">DISPATCH NUMBER (IF NOT ATTENDED)</Label>
              <Input id="dispatchNumber" {...formik.getFieldProps("dispatchNumber")} />
            </div>
            <div className="space-y-2">
              <Label htmlFor="remarks">Remark (IF NOT ATTENDED)</Label>
              <Textarea id="remarks" className="h-10" {...formik.getFieldProps("remarks")} />
            </div>
          </div>
        )}
      </div>

      <div className="flex justify-end gap-3 pt-4 border-t border-gray-100">
        <Button
          type="button"
          variant="outline"
          onClick={() => router.back()}
          disabled={loading}
        >
          Cancel
        </Button>
        <Button
          type="submit"
          disabled={loading}
          className="bg-[#00563B] hover:bg-[#368F8B] min-w-[120px]"
        >
          {loading ? (
            <>
              <Loader2 className="mr-2 h-4 w-4 animate-spin" />
              Saving...
            </>
          ) : (
            "Save Event"
          )}
        </Button>
      </div>
    </form>
  );
};

export default EventForm;
