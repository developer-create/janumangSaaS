"use client";

import { useEffect, useState } from "react";
import { useRouter } from "@app/hooks/useCustomRouter";
import { useParams } from "next/navigation";
import axios from "@app/utils/axios";
import { toast } from "react-toastify";
import { ContentHeader } from "@app/components";
import { RouteGuard } from '@app/components/RouteGuard';
import { PERMISSIONS } from "@app/config/permissions";
import { Button } from "@app/components/ui/button";
import { Label } from "@app/components/ui/label";
import { Card, CardContent, CardHeader } from "@app/components/ui/card";
import { Badge } from "@app/components/ui/badge";
import {
  User,
  MapPin,
  Calendar,
  Twitter,
  Instagram,
  Facebook,
  Link as LinkIcon,
  Info,
  Car,
  Settings,
} from "lucide-react";
import { ViewPageActions } from "@app/components/ViewPageActions";

interface IMember {
  _id: string;
  addedBy: string;
  name: string;
  voterId: string;
  mobile: string;
  fatherName: string;
  dob: string;
  dom: string;
  district: string;
  block: string;
  boothName: string;
  boothNumber: string;
  grampanchayat: string;
  village: string;
  samiti: string;
  toll: string;
  jaati: string;
  age: number;
  education: string;
  address: string;
  gender: string;
  vehicle: string;
  group: string;
  govtEmployee: string;
  party: string;
  postYear: string;
  code: string;
  nariSammanYojna: string;
  farmerLoanWaiver: string;
  reference: string;
  remark: string;
  facebook: string;
  instagram: string;
  // 50 Boolean Roles
  bg?: boolean; bc?: boolean; er?: boolean; br?: boolean; ip?: boolean; sc?: boolean; sa?: boolean; yc?: boolean;
  ap?: boolean; fp?: boolean; pp?: boolean; wc?: boolean; pa?: boolean; pc?: boolean; ak?: boolean; fm?: boolean;
  zp?: boolean; vp?: boolean; sr?: boolean; in_field?: boolean; eo?: boolean; gs?: boolean; us?: boolean;
  pw?: boolean; nl?: boolean; fr?: boolean; so?: boolean; st?: boolean; ob?: boolean; smw?: boolean; smtw?: boolean;
  it?: boolean; test?: boolean; dyc?: boolean; dcc?: boolean; obc?: boolean; cell_mp?: boolean; dt?: boolean;
  dp?: boolean; avp?: boolean; meet?: boolean; media?: boolean; mla_x_mla?: boolean; vech?: boolean;
  it_cell_exp?: boolean; info?: boolean; nsui?: boolean; imp?: boolean; advise?: boolean; ref_code?: boolean;
  twitter: string;
  startLat: number;
  startLong: number;
  startDate: string;
  endLat: number;
  endLong: number;
  endDate: string;
  image: string;
  createdAt: string;
  updatedAt: string;
}

const ViewMember = () => {
  const router = useRouter();
  const { id } = useParams();
  const [member, setMember] = useState<IMember | null>(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchMember = async () => {
      try {
        const { data } = await axios.get(`/members/${id}`);
        setMember(data.data);
      } catch (error: unknown) {
        toast.error("Failed to load member details");
        router.push("/member-list");
      } finally {
        setLoading(false);
      }
    };

    if (id) fetchMember();
  }, [id]);

  if (loading)
    return (
      <div className="p-10 text-center text-gray-500 dark:text-gray-400">
        Loading Member Data...
      </div>
    );
  if (!member)
    return (
      <div className="p-10 text-center text-red-500">Member not found</div>
    );

  const formatDate = (dateString: string) => {
    if (!dateString) return "N/A";
    const d = new Date(dateString);
    return isNaN(d.getTime()) ? "N/A" : d.toLocaleDateString();
  };

  const formatDateTime = (dateString: string) => {
    if (!dateString) return "N/A";
    const d = new Date(dateString);
    return isNaN(d.getTime()) ? "N/A" : d.toString();
  };

  /* Define export data */
  const getExportData = () => {
    if (!member) return {};
    return {
      Name: member.name,
      Mobile: member.mobile,
      "Voter ID": member.voterId,
      Gender: member.gender,
      "Father Name": member.fatherName,
      DOB: formatDate(member.dob),
      Age: member.age,
      Education: member.education,
      Jaati: member.jaati,
      District: member.district,
      Block: member.block,
      Village: member.village,
      Address: member.address,
      Party: member.party,
      Group: member.group,
      "Govt Employee": member.govtEmployee,
      "Post Year": member.postYear,
      Reference: member.reference,
      Code: member.code,
      BG: member.bg ? "Yes" : "No", BC: member.bc ? "Yes" : "No", ER: member.er ? "Yes" : "No",
      BR: member.br ? "Yes" : "No", IP: member.ip ? "Yes" : "No", SC: member.sc ? "Yes" : "No",
      SA: member.sa ? "Yes" : "No", YC: member.yc ? "Yes" : "No", AP: member.ap ? "Yes" : "No",
      FP: member.fp ? "Yes" : "No", PP: member.pp ? "Yes" : "No", WC: member.wc ? "Yes" : "No",
      PA: member.pa ? "Yes" : "No", PC: member.pc ? "Yes" : "No", AK: member.ak ? "Yes" : "No",
      FM: member.fm ? "Yes" : "No", ZP: member.zp ? "Yes" : "No", VP: member.vp ? "Yes" : "No",
      SR: member.sr ? "Yes" : "No", IN: member.in_field ? "Yes" : "No", EO: member.eo ? "Yes" : "No",
      GS: member.gs ? "Yes" : "No", US: member.us ? "Yes" : "No", PW: member.pw ? "Yes" : "No",
      NL: member.nl ? "Yes" : "No", FR: member.fr ? "Yes" : "No", SO: member.so ? "Yes" : "No",
      ST: member.st ? "Yes" : "No", OB: member.ob ? "Yes" : "No", SMW: member.smw ? "Yes" : "No",
      SMTW: member.smtw ? "Yes" : "No", IT: member.it ? "Yes" : "No", TEST: member.test ? "Yes" : "No",
      DYC: member.dyc ? "Yes" : "No", DCC: member.dcc ? "Yes" : "No", OBC: member.obc ? "Yes" : "No",
      "CELL/MP": member.cell_mp ? "Yes" : "No", DT: member.dt ? "Yes" : "No", DP: member.dp ? "Yes" : "No",
      AVP: member.avp ? "Yes" : "No", MEET: member.meet ? "Yes" : "No", MEDIA: member.media ? "Yes" : "No",
      "MLA,X MLA": member.mla_x_mla ? "Yes" : "No", VECH: member.vech ? "Yes" : "No",
      "IT CELL EXP": member.it_cell_exp ? "Yes" : "No", INFO: member.info ? "Yes" : "No",
      NSUI: member.nsui ? "Yes" : "No", IMP: member.imp ? "Yes" : "No", ADVISE: member.advise ? "Yes" : "No",
      REF: member.ref_code ? "Yes" : "No",
      Vehicle: member.vehicle,
      "Added By": member.addedBy,
      "Start Date": member.startDate
        ? new Date(member.startDate).toString()
        : "",
      "End Date": member.endDate ? new Date(member.endDate).toString() : "",
    };
  };

  return (
    <RouteGuard requiredPermissions={[PERMISSIONS.VIEW_MEMBERS]}>
      <ContentHeader title="Member Details" />
      <section className="content pb-10">
        <div className="container-fluid px-4">
          <Card className="max-w-6xl mx-auto shadow-2xl border-none overflow-hidden rounded-2xl dark:bg-card dark:border-gray-800">
            <CardHeader className="bg-[#368F8B] text-white p-6 md:p-8 dark:bg-[#2d7a76]">
              <div className="flex flex-col md:flex-row justify-between items-center gap-6">
                <div className="flex flex-col md:flex-row items-center gap-6">
                  {member.image ? (
                    <img
                      src={member.image}
                      alt={member.name}
                      className="w-32 h-32 rounded-2xl border-4 border-white/30 object-cover shadow-2xl"
                    />
                  ) : (
                    <div className="w-32 h-32 rounded-2xl bg-white/20 flex items-center justify-center border-4 border-white/30 backdrop-blur-sm">
                      <User className="w-16 h-16 text-white" />
                    </div>
                  )}
                  <div className="text-center md:text-left">
                    <h2 className="text-4xl font-extrabold tracking-tight">
                      {member.name || "Unnamed Member"}
                    </h2>
                    <div className="flex flex-wrap justify-center md:justify-start gap-2 mt-3">
                      {(member.code || "")
                        .split(",")
                        .filter(Boolean)
                        .map((c) => (
                          <Badge
                            key={c}
                            className="bg-white/20 hover:bg-white/30 text-white border-white/40 px-3 py-1"
                          >
                            {c}
                          </Badge>
                        ))}
                      {!member.code && (
                        <Badge className="bg-white/10 text-white/70 italic border-transparent">
                          No Legacy Codes Assigned
                        </Badge>
                      )}
                    </div>
                    {/* Render boolean flags */}
                    <div className="flex flex-wrap justify-center md:justify-start gap-2 mt-2">
                      {[
                        { key: "bg", label: "BG" }, { key: "bc", label: "BC" }, { key: "er", label: "ER" },
                        { key: "br", label: "BR" }, { key: "ip", label: "IP" }, { key: "sc", label: "SC" },
                        { key: "sa", label: "SA" }, { key: "yc", label: "YC" }, { key: "ap", label: "AP" },
                        { key: "fp", label: "FP" }, { key: "pp", label: "PP" }, { key: "wc", label: "WC" },
                        { key: "pa", label: "PA" }, { key: "pc", label: "PC" }, { key: "ak", label: "AK" },
                        { key: "fm", label: "FM" }, { key: "zp", label: "ZP" }, { key: "vp", label: "VP" },
                        { key: "sr", label: "SR" }, { key: "in_field", label: "IN" }, { key: "eo", label: "EO" },
                        { key: "gs", label: "GS" }, { key: "us", label: "US" }, { key: "pw", label: "PW" },
                        { key: "nl", label: "NL" }, { key: "fr", label: "FR" }, { key: "so", label: "SO" },
                        { key: "st", label: "ST" }, { key: "ob", label: "OB" }, { key: "smw", label: "SMW" },
                        { key: "smtw", label: "SMTW" }, { key: "it", label: "IT" }, { key: "test", label: "TEST" },
                        { key: "dyc", label: "DYC" }, { key: "dcc", label: "DCC" }, { key: "obc", label: "OBC" },
                        { key: "cell_mp", label: "CELL/MP" }, { key: "dt", label: "DT" }, { key: "dp", label: "DP" },
                        { key: "avp", label: "AVP" }, { key: "meet", label: "MEET" }, { key: "media", label: "MEDIA" },
                        { key: "mla_x_mla", label: "MLA,X MLA" }, { key: "vech", label: "VECH" },
                        { key: "it_cell_exp", label: "IT CELL EXP" }, { key: "info", label: "INFO" },
                        { key: "nsui", label: "NSUI" }, { key: "imp", label: "IMP" }, { key: "advise", label: "ADVISE" },
                        { key: "ref_code", label: "REF" }
                      ].filter(c => (member as any)[c.key]).map(c => (
                        <Badge
                          key={c.key}
                          className="bg-yellow-500/80 hover:bg-yellow-500 text-white border-white/40 px-3 py-1 mt-1"
                        >
                          {c.label}
                        </Badge>
                      ))}
                    </div>
                    <p className="text-[#E0F2F1] text-sm mt-4 opacity-90 flex items-center gap-2 justify-center md:justify-start">
                      <Info className="w-4 h-4" />
                      Survey ID: {member._id.slice(-8).toUpperCase()} | Added
                      by: {member.addedBy || "Admin"}
                    </p>
                  </div>
                </div>
                <div className="flex gap-3 items-center">
                  <ViewPageActions
                    getExportData={getExportData}
                    fileName={`Member_${member.name.replace(/\s+/g, "_")}`}
                    className="bg-white/10 text-white hover:bg-white/20 border-white/40"
                  />
                  <Button
                    className="bg-white text-[#368F8B] hover:bg-white/90 font-bold px-6 border-none shadow-lg"
                    onClick={() =>
                      router.push(`/member-list/${member._id}/edit`)
                    }
                  >
                    Edit Profile
                  </Button>
                  <Button
                    variant="outline"
                    className="bg-transparent text-white border-white/40 hover:bg-white/10 px-6 font-bold"
                    onClick={() => router.back()}
                  >
                    Back
                  </Button>
                </div>
              </div>
            </CardHeader>

            <CardContent className="p-6 md:p-10 bg-slate-50/50 dark:bg-gray-900/50 space-y-10">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {/* Personal Information */}
                <div className="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/40 dark:shadow-none transition-all hover:shadow-2xl hover:shadow-gray-200/60">
                  <h3 className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-3">
                    <User className="w-6 h-6 text-[#368F8B]" />
                    Personal Information
                  </h3>
                  <div className="space-y-5">
                    <InfoBox label="Full Name" value={member.name} />
                    <InfoBox label="Father's Name" value={member.fatherName} />
                    <InfoBox label="Gender" value={member.gender} />
                    <InfoBox
                      label="Date of Birth"
                      value={formatDate(member.dob)}
                    />
                    <InfoBox label="Age" value={member.age?.toString()} />
                    <InfoBox label="Education" value={member.education} />
                    <InfoBox label="Jati" value={member.jaati} />
                    <InfoBox
                      label="Marriage Date"
                      value={formatDate(member.dom)}
                    />
                  </div>
                </div>

                {/* Contact & Location */}
                <div className="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/40 dark:shadow-none transition-all hover:shadow-2xl hover:shadow-gray-200/60">
                  <h3 className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-3">
                    <MapPin className="w-6 h-6 text-[#E53935]" />
                    Location & Contact
                  </h3>
                  <div className="space-y-5">
                    <InfoBox label="Mobile Number" value={member.mobile} />
                    <InfoBox label="Votar Code" value={member.voterId} />
                    <InfoBox label="District" value={member.district} />
                    <InfoBox label="Samithi" value={member.samiti} />
                    <InfoBox label="Block" value={member.block} />
                    <InfoBox
                      label="Gram Panchayat"
                      value={member.grampanchayat}
                    />
                    <InfoBox label="Village" value={member.village} />
                    <InfoBox label="Majra/Falia/Tolla" value={member.toll} />
                    <InfoBox
                      label="Full Address"
                      value={member.address}
                      highlight
                    />
                  </div>
                </div>

                {/* Affiliations & Schemes */}
                <div className="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/40 dark:shadow-none transition-all hover:shadow-2xl hover:shadow-gray-200/60">
                  <h3 className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-3">
                    <Settings className="w-6 h-6 text-[#FB8C00]" />
                    Roles & Status
                  </h3>
                  <div className="space-y-5">
                    <InfoBox label="Party" value={member.party} />
                    <InfoBox label="Group" value={member.group} />
                    <InfoBox
                      label="Govt Employee"
                      value={member.govtEmployee}
                    />
                    <InfoBox
                      label="पद वर्ष (Post Year)"
                      value={member.postYear}
                    />
                    <InfoBox
                      label="Nari Samman Yojna"
                      value={member.nariSammanYojna}
                    />
                    <InfoBox
                      label="Farmer Loan Waiver"
                      value={member.farmerLoanWaiver}
                    />
                    <InfoBox label="Reference" value={member.reference} />
                    <div className="pt-2">
                      <Label className="text-gray-400 dark:text-gray-500 text-xs uppercase font-bold tracking-widest mb-2 block">
                        Vehicle Owned
                      </Label>
                      <div className="flex flex-wrap gap-2">
                        {(member.vehicle || "")
                          .split(",")
                          .filter(Boolean)
                          .map((v) => (
                            <Badge
                              key={v}
                              variant="secondary"
                              className="bg-orange-50 dark:bg-orange-900/20 text-orange-700 dark:text-orange-400 hover:bg-orange-100 dark:hover:bg-orange-900/30 border-none px-3 flex items-center gap-1"
                            >
                              <Car className="w-3 h-3" /> {v}
                            </Badge>
                          ))}
                        {!member.vehicle && (
                          <span className="text-gray-400 dark:text-gray-500 italic text-sm">
                            None reported
                          </span>
                        )}
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {/* Social Media & Remarks */}
              <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div className="lg:col-span-2 bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/40 dark:shadow-none">
                  <h3 className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-3">
                    <LinkIcon className="w-6 h-6 text-[#5E35B1]" />
                    Social Media Links
                  </h3>
                  <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <SocialCard
                      icon={<Facebook className="w-6 h-6 text-blue-600" />}
                      label="Facebook"
                      value={member.facebook}
                    />
                    <SocialCard
                      icon={<Instagram className="w-6 h-6 text-pink-600" />}
                      label="Instagram"
                      value={member.instagram}
                    />
                    <SocialCard
                      icon={<Twitter className="w-6 h-6 text-sky-500" />}
                      label="Twitter"
                      value={member.twitter}
                    />
                  </div>
                </div>
                <div className="bg-[#E0F2F1]/30 dark:bg-[#E0F2F1]/10 p-8 rounded-3xl border border-[#368F8B]/20 dark:border-[#368F8B]/40">
                  <h3 className="text-xl font-bold text-[#368F8B] mb-4 flex items-center gap-3">
                    <Info className="w-6 h-6" />
                    Remarks
                  </h3>
                  <p className="text-gray-700 dark:text-gray-300 italic leading-relaxed">
                    {member.remark ||
                      "No additional remarks provided for this member survey."}
                  </p>
                </div>
              </div>

              {/* Tracking Information */}
              <div className="bg-white dark:bg-gray-800 p-8 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-xl shadow-gray-200/40 dark:shadow-none">
                <h3 className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-8 flex items-center gap-3">
                  <Calendar className="w-6 h-6 text-[#1E88E5]" />
                  Survey Tracking Details
                </h3>
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                  <div className="space-y-6 relative pl-6 border-l-2 border-dashed border-gray-100 dark:border-gray-700">
                    <div className="absolute top-0 -left-[9px] w-4 h-4 rounded-full bg-[#368F8B]"></div>
                    <p className="text-xs font-black uppercase tracking-[0.2em] text-[#368F8B]">
                      Start Location
                    </p>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <InfoBox
                        label="Timestamp"
                        value={formatDateTime(member.startDate)}
                      />
                      <div className="flex gap-4">
                        <InfoBox
                          label="Latitude"
                          value={member.startLat?.toString()}
                        />
                        <InfoBox
                          label="Longitude"
                          value={member.startLong?.toString()}
                        />
                      </div>
                    </div>
                  </div>
                  <div className="space-y-6 relative pl-6 border-l-2 border-dashed border-gray-100 dark:border-gray-700">
                    <div className="absolute top-0 -left-[9px] w-4 h-4 rounded-full bg-[#E53935]"></div>
                    <p className="text-xs font-black uppercase tracking-[0.2em] text-[#E53935]">
                      End Location
                    </p>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                      <InfoBox
                        label="Timestamp"
                        value={formatDateTime(member.endDate)}
                      />
                      <div className="flex gap-4">
                        <InfoBox
                          label="Latitude"
                          value={member.endLat?.toString()}
                        />
                        <InfoBox
                          label="Longitude"
                          value={member.endLong?.toString()}
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>
      </section>
    </RouteGuard>
  );
};

const InfoBox = ({
  label,
  value,
  highlight,
}: {
  label: string;
  value?: string;
  highlight?: boolean;
}) => (
  <div className="group">
    <Label className="text-gray-400 dark:text-gray-500 text-[10px] uppercase font-bold tracking-widest mb-1 block group-hover:text-[#368F8B] transition-colors">
      {label}
    </Label>
    <p
      className={`font-semibold text-gray-800 dark:text-gray-100 wrap-break-word ${highlight ? "text-sm bg-gray-50 dark:bg-gray-700 p-2 rounded-lg border border-gray-100 dark:border-gray-600" : "text-base"}`}
    >
      {value || (
        <span className="text-gray-300 dark:text-gray-600 italic font-normal">
          Not Provided
        </span>
      )}
    </p>
  </div>
);

const SocialCard = ({
  icon,
  label,
  value,
}: {
  icon: React.ReactNode;
  label: string;
  value?: string;
}) => (
  <div className="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 hover:border-[#368F8B]/30 dark:hover:border-[#368F8B]/50 hover:bg-[#368F8B]/5 dark:hover:bg-[#368F8B]/10 transition-all cursor-default">
    <div className="w-12 h-12 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm border border-gray-100 dark:border-gray-700">
      {icon}
    </div>
    <div className="flex-1 min-w-0">
      <p className="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">
        {label}
      </p>
      <p className="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">
        {value || "N/A"}
      </p>
    </div>
  </div>
);

export default ViewMember;
