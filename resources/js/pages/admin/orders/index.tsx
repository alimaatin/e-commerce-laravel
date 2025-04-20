import TextLink from '@/components/text-link';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuItem, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, Order } from '@/types';
import { MoreHorizontalIcon } from 'lucide-react';
import { Head, usePage } from '@inertiajs/react';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { useState } from 'react';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Admin',
        href: '/dashboard/admin',
    },
    {
        title: 'Orders',
        href: '/dashboard/admin/orders',
    },
];

export default function AdminOrders() {
    const [filter, setFilter] = useState<string>('all');
    const [priceSort, setPriceSort] = useState<string>('highest');

    const { orders } = usePage<{ orders: Order[] }>().props;

    const sortedOrders = orders.sort((a, b) => {
        if (priceSort === 'highest') {
            return b.total_price - a.total_price;
        } else {
            return a.total_price - b.total_price;
        }
    });

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard Orders" />
            <div className="flex h-full flex-1 items-start flex-col gap-4 rounded-xl p-4">
                <div className='flex gap-2'>
                    <Select onValueChange={(value) => setFilter(value)} defaultValue="all">
                        <SelectTrigger className='w-fit'>
                            <SelectValue placeholder="Sort" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="all">All</SelectItem>
                            <SelectItem value="failed">Failed</SelectItem>
                            <SelectItem value="pending">Pending</SelectItem>
                            <SelectItem value="completed">Completed</SelectItem>
                        </SelectContent>
                    </Select>
                    <Select onValueChange={(value) => setPriceSort(value)} defaultValue="highest">
                        <SelectTrigger className='w-fit'>
                            <SelectValue placeholder="Price" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem value="highest">Highest</SelectItem>
                            <SelectItem value="lowest">Lowest</SelectItem>
                        </SelectContent>
                    </Select>
                </div>
                <Table>
                    <TableCaption>Orders</TableCaption>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Order ID</TableHead>
                            <TableHead>Customer</TableHead>
                            <TableHead>Total</TableHead>
                            <TableHead>Status</TableHead>
                            <TableHead>Actions</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        {orders.map((order: Order) => (
                            (filter === 'all' || order.status === filter) && (
                        <TableRow key={order.id}> 
                            <TableCell>{order.id}</TableCell>
                            <TableCell>{order.name}</TableCell>
                            <TableCell>{order.total_price}</TableCell>
                            <TableCell>{order.status}</TableCell>
                            <TableCell>
                                <TextLink href={route('admin.orders.edit', { order: order.id })}>
                                Edit
                                </TextLink>
                                    </TableCell>
                                </TableRow>
                            )
                        ))}
                    </TableBody>
                </Table>
            </div>
        </AppLayout>
    );
}
