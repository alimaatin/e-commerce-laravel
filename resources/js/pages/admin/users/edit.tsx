import { Button } from "@/components/ui/button";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
import { Label } from "@/components/ui/label";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem, User, UserForm } from "@/types";
import { Head, useForm, usePage } from "@inertiajs/react";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/dashboard/admin/users',
    },
    {
        title: 'Edit',
        href: '/dashboard/admin/users/{user}',
    },
];

export default function AdminUsersEdit() {
    const { user } = usePage<{user: User}>().props;
    const { data, setData, put, processing, errors } = useForm<Required<UserForm>>({
        role: user.role,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
          put(route('admin.users.update', { user: user.id }), {
        });
    }
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Edit User" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                <h1 className="text-2xl font-bold">Edit User</h1>
                <form className="flex flex-col gap-6" onSubmit={handleSubmit}>
                    <div className="flex flex-col gap-6">
                        <div className="flex flex-col gap-2">
                            <Label htmlFor="name">Role</Label>
                            <DropdownMenu>
                                <DropdownMenuTrigger asChild>
                                    <Button variant="outline">{data.role}</Button>
                                </DropdownMenuTrigger>
                                <DropdownMenuContent>
                                  <DropdownMenuItem onClick={() => setData({ role: 'admin' })}>Admin</DropdownMenuItem>
                                  <DropdownMenuItem onClick={() => setData({ role: 'user' })}>User</DropdownMenuItem>
                                </DropdownMenuContent>
                            </DropdownMenu>
                        </div>
                        <Button type="submit" disabled={processing}>Save</Button>
                    </div>
                </form>
            </div>
        </AppLayout>
    )
}
