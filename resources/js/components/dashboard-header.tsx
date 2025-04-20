import { Link, usePage } from "@inertiajs/react";
import TextLink from "./text-link";
import { ShoppingCart } from "lucide-react";
import { Input } from "./ui/input";
import AppLogo from "./app-logo";
import { Button, buttonVariants } from "./ui/button";
import { BreadcrumbItem, SharedData } from "@/types";
import { NavUser } from "./nav-user";
import { DropdownMenuContent } from "./ui/dropdown-menu";
import { DropdownMenu } from "./ui/dropdown-menu";
import { DropdownMenuTrigger } from "./ui/dropdown-menu";
import { Avatar } from "./ui/avatar";
import { AvatarImage } from "./ui/avatar";
import { AvatarFallback } from "./ui/avatar";
import { UserMenuContent } from "./user-menu-content";
import { useInitials } from "@/hooks/use-initials";
import { SidebarTrigger } from "./ui/sidebar";
import { Breadcrumbs } from "./breadcrumbs";
import Cart from "./cart";
export default function DashboardHeader({ breadcrumbs = [] }: { breadcrumbs?: BreadcrumbItem[] }) {
  const page = usePage<SharedData>();
  const { auth } = page.props;
  const getInitials = useInitials();

  return(
      <div className="w-full border-b">
        <header className="mx-auto flex flex-col max-w-7xl p-4 w-full">
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-1">
            <SidebarTrigger className="-ml-1 lg:hidden md:hidden" />
            <AppLogo />
          </div>
          <Input type="search" className="dark:bg-white dark:text-black w-72 focus:w-80 hidden lg:block transition-all" placeholder="Search..."/>
          <div className="flex gap-4 items-center">
            <Cart />
            { auth.user ?
            <DropdownMenu>
              <DropdownMenuTrigger asChild>
                  <Button variant="ghost" className="size-10 rounded-full p-1">
                      <Avatar className="size-8 overflow-hidden rounded-full">
                          <AvatarImage src={auth.user.avatar} alt={auth.user.name} />
                          <AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                              {getInitials(auth.user.name)}
                          </AvatarFallback>
                      </Avatar>
                  </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent className="w-56" align="end">
                  <UserMenuContent user={auth.user} />
              </DropdownMenuContent>
            </DropdownMenu>
            :
            <div className="flex gap-2">
              <Link href={route('login')} className={buttonVariants({variant: 'default'})}>
                Login
              </Link>
              <Link href={route('register')} className={buttonVariants({variant: 'outline'})}>
                Register
              </Link>    
            </div>
            }
          </div>
        </div>
        <div className="mt-4">
          <Breadcrumbs breadcrumbs={breadcrumbs} /> 
        </div>
      </header>
    </div>
  );
}