import TextLink from '@/components/text-link';
import { Button, buttonVariants } from '@/components/ui/button';
import { PlaceholderPattern } from '@/components/ui/placeholder-pattern';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/app-layout';
import { cn } from '@/lib/utils';
import { Product, type BreadcrumbItem } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import { PencilIcon, PlusIcon } from 'lucide-react';

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
        title: 'Products',
        href: '/dashboard/admin/products',
    },
];

export default function AdminProducts() {
    const { products } = usePage<{ products: Product[] }>().props;
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard Products" />
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
              <Link href="/dashboard/admin/products/create" className={cn(buttonVariants({ variant: 'default' }), 'w-fit')}>
                <PlusIcon />
                Add Product
              </Link>
              <Table>
                  <TableCaption>Products</TableCaption>
                  <TableHeader>
                      <TableRow>
                          <TableHead>ID</TableHead>
                          <TableHead>Name</TableHead>
                          <TableHead>Price</TableHead>
                          <TableHead>Stock</TableHead>
                          <TableHead>Discount</TableHead>
                          <TableHead>Status</TableHead>
                          <TableHead>Actions</TableHead>
                      </TableRow>
                  </TableHeader>
                  <TableBody>
                    {products.map((product: Product) => (
                      <TableRow key={product.id}>
                        <TableCell>{product.id}</TableCell>
                        <TableCell>{product.name}</TableCell>
                        <TableCell>{product.price}</TableCell>
                        <TableCell>{product.stock}</TableCell>
                        <TableCell>{product.discount}</TableCell>
                        <TableCell>{product.is_active ? 'Active' : 'Inactive'}</TableCell>
                        <TableCell>
                          <TextLink href={route('admin.products.edit', { product: product.id })}>
                            Edit
                          </TextLink>
                        </TableCell>
                      </TableRow>
                    ))}
                  </TableBody>
              </Table>
            </div>
        </AppLayout>
    );
}
