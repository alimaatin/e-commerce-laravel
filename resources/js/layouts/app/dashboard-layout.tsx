import { AppContent } from '@/components/app-content';
import { AppShell } from '@/components/app-shell';
import { DashboardSidebar } from '@/components/dashboard-sidebar';
import { AppSidebarHeader } from '@/components/app-sidebar-header';
import { type BreadcrumbItem } from '@/types';
import { type PropsWithChildren } from 'react';
import DashboardHeader from '@/components/dashboard-header';
import MobileBottomNav from '@/components/mobile-bottom-nav';

export default function DashboardLayout({ children, breadcrumbs = [] }: PropsWithChildren<{ breadcrumbs?: BreadcrumbItem[] }>) {
    return (
        <AppShell variant="sidebar">
            <DashboardSidebar />
            <AppContent variant="sidebar">
                <DashboardHeader breadcrumbs={breadcrumbs} />
                {children}
            </AppContent>
            <MobileBottomNav />
        </AppShell>
    );
}
