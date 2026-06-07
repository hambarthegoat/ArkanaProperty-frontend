import { createBrowserRouter, Navigate } from "react-router";
import { ArrowRight, MessageSquare } from "lucide-react";
import { LandingPage } from "./pages/LandingPage";
import { AdminDashboard } from "./pages/AdminDashboard";
import { MarketingDashboard } from "./pages/MarketingDashboard";
import { UserPortal } from "./pages/UserPortal";
import { LoginPage } from "./pages/LoginPage";
import { MainLayout } from "./layouts/MainLayout";
import { DashboardLayout } from "./layouts/DashboardLayout";
import { LeadsManagement } from "./pages/admin/LeadsManagement";
import { KavlingManagement } from "./pages/admin/KavlingManagement";
import { HousingManagement } from "./pages/admin/HousingManagement";
import { PropertyDetail } from "./pages/PropertyDetail";
import { MarketingReports } from "./pages/admin/MarketingReports";
import { MarketingReportEntry } from "./pages/marketing/MarketingReportEntry";
import { CalendarManagement } from "./pages/marketing/CalendarManagement";

import { UserTimeline } from "./pages/resident/UserTimeline";

export const router = createBrowserRouter([
  {
    path: "/",
    element: <MainLayout />,
    children: [
      { index: true, element: <LandingPage /> },
      { path: "property/:id", element: <PropertyDetail /> },
    ],
  },
  {
    path: "/login",
    element: <LoginPage />,
  },
  {
    path: "/admin",
    element: <DashboardLayout role="admin" />,
    children: [
      { index: true, element: <AdminDashboard /> },
      { path: "leads", element: <LeadsManagement /> },
      { path: "kavling", element: <KavlingManagement /> },
      { path: "perumahan", element: <HousingManagement /> },
      { path: "reports", element: <MarketingReports /> },
    ],
  },
  {
    path: "/marketing",
    element: <DashboardLayout role="marketing" />,
    children: [
      { index: true, element: <MarketingDashboard /> },
      { path: "calendar", element: <CalendarManagement /> },
      { path: "reports", element: <MarketingReportEntry /> },
    ],
  },
  {
    path: "/portal",
    element: <DashboardLayout role="user" />,
    children: [
      { index: true, element: <UserPortal /> },
      { path: "reminders", element: <UserTimeline /> },
      { path: "support", element: <Bantuan /> },
    ],
  },
  {
    path: "*",
    element: <Navigate to="/" replace />,
  },
]);

function Bantuan() {
  const categories = [
    { title: "Pembayaran & KPR", desc: "Masalah cicilan, konfirmasi transfer, atau berkas bank." },
    { title: "Progres Pembangunan", desc: "Tanya jadwal finishing atau serah terima kunci." },
    { title: "Komplain Unit", desc: "Lapor kerusakan atau renovasi selama masa garansi." },
    { title: "Teknis Aplikasi", desc: "Masalah login portal atau notifikasi tidak masuk." },
  ];

  return (
    <div className="space-y-8">
      <div>
        <h1 className="text-2xl font-black text-primary">Pusat Bantuan</h1>
        <p className="text-primary/60">Kami siap membantu setiap kendala hunian Anda.</p>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {categories.map((cat, i) => (
          <div key={i} className="bg-white p-8 rounded-[32px] border border-border-subtle shadow-sm hover:border-accent transition-all group">
            <h3 className="font-black text-primary mb-2 group-hover:text-accent transition-colors">{cat.title}</h3>
            <p className="text-xs text-primary/60 leading-relaxed">{cat.desc}</p>
          </div>
        ))}
      </div>

      <div className="bg-primary text-white p-10 rounded-[40px] shadow-2xl relative overflow-hidden">
        <div className="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-8 text-center lg:text-left">
          <div className="max-w-md">
            <h2 className="text-2xl font-black mb-4 italic">Pusat Layanan Terpadu</h2>
            <p className="text-white/60 text-sm">Untuk semua kendala di atas, hubungi Customer Care resmi ArkanaProperty melalui WhatsApp resmi kami.</p>
          </div>
          <div className="flex flex-col gap-4 w-full lg:w-auto">
            <a href="https://wa.me/628123456789" className="px-8 py-4 bg-accent text-white rounded-2xl font-black flex items-center justify-center gap-3 hover:scale-105 transition-all shadow-xl shadow-accent/20">
              <MessageSquare size={24} /> Chat Customer Care
            </a>
            <p className="text-[10px] text-white/40 font-bold uppercase tracking-widest text-center">Tersedia: Senin - Sabtu (08:00 - 17:00 WIB)</p>
          </div>
        </div>
        <div className="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full translate-x-1/3 -translate-y-1/3"></div>
      </div>
    </div>
  );
}
