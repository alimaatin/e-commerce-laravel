import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem } from "@/components/ui/dropdown-menu";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem, OrderForm, Order, Product, ProductForm, OrderDetail } from "@/types";
import { Head, usePage } from "@inertiajs/react";
import { useForm } from "@inertiajs/react";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/dashboard/admin/products',
    },
    {
        title: 'Edit',
        href: 'dashboard/admin/products/{product}',
    },
];

export default function AdminOrdersEdit() {
    const { order } = usePage<{order: Order}>().props;
    const { data, setData, put, processing, errors } = useForm<{status: string}>({
      status: order.status,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        put(route('admin.orders.update', {order: order.id}), {preserveScroll: true});
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
          <Head title="Edit Product" />
          <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 className="text-2xl font-bold">Edit Product</h1>
            <form className="flex flex-col gap-6" onSubmit={handleSubmit} encType="multipart/form-data">
              <div className="flex flex-col gap-6">
                <div className="flex flex-col gap-2">
                  <div className="flex gap-2">
                    <Label>Name</Label>
                    <p>{order.name}</p>
                  </div>
                  <div className="flex items-center gap-2">
                    <Label>Email</Label>
                    <p>{order.email}</p>
                  </div>
                  <div className="flex items-center gap-2">
                    <Label>Address</Label>
                    <p>{order.address}</p>
                  </div>
                  <div className="flex items-center gap-2">
                    <Label>Postal Code</Label>
                    <p>{order.postal_code}</p>
                  </div>
                  <div className="flex items-center gap-2">
                    <Label>Total Price</Label>
                    <p>{order.total_price.toLocaleString()}</p>
                  </div>
                  <div className="flex flex-col gap-2">
                    <Label>Items</Label>
                    <div className="flex gap-2">
                      {order.order_details.map((item: OrderDetail) => (
                        <div key={item.id} className="flex justify-between items-center">
                          <div className="flex gap-2 items-center">
                            <img src={`/storage/products/${item.product.image}`} alt={item.product.name} className="w-12 h-12 rounded-md" />
                            <div>
                              <p>{item.product.name}</p>
                              <p className="text-sm text-gray-500">{item.product.discount ? (item.product.discounted_price).toLocaleString() : item.product.price.toLocaleString()} x {item.quantity}</p>
                            </div>
                          </div>
                        </div>
                      ))}
                    </div>
                  </div>
                  <Label htmlFor="is_active">Status</Label>
                  <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                      <Button variant="outline">{data.status}</Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                      <DropdownMenuItem onClick={() => setData('status', 'pending')}>Pending</DropdownMenuItem>
                      <DropdownMenuItem onClick={() => setData('status', 'completed')}>Completed</DropdownMenuItem> 
                    </DropdownMenuContent>
                  </DropdownMenu>
                </div>
              </div>
              <Button type="submit" disabled={processing}>Update</Button>
            </form>
          </div>
        </AppLayout>
    )
}