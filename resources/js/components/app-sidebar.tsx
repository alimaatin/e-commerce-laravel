import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem, type SharedData } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { ArrowBigLeft, BookOpen, ClipboardCopy, Folder, LayoutGrid, List, Package, Settings, User } from 'lucide-react';
import AppLogo from './app-logo';

export function AppSidebar() {
    const page = usePage<SharedData>();
    const { auth } = page.props;

    const mainNavItems: NavItem[] = [
        {
            title: 'Dashboard',
            href: '/dashboard',
            icon: LayoutGrid,
        },
        {
            title: 'Orders',
            href: '/dashboard/orders',
            icon: ClipboardCopy,
        },
        {
            title: 'Settings',
            href: route('profile.edit'),
            icon: Settings,
        },
        {
            title: 'Admin',
            href: '/admin',
            icon: User,
            isActive: auth.user.role === "admin",
        },
        {
            title: 'Seller',
            href: route('dashboard.vendors'),
            icon: User,
        },
    ];

    const footerNavItems: NavItem[] = [
        {
            title: 'Become a seller',
            href: route('seller.create'),
            icon: ArrowBigLeft,
            isActive: auth.user.role === "user",
        },
    ];

    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href="/" prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
