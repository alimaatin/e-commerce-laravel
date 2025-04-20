import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { DropdownMenu, DropdownMenuTrigger, DropdownMenuContent, DropdownMenuItem } from "@/components/ui/dropdown-menu";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem, Product, ProductForm } from "@/types";
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

export default function AdminProductsEdit() {
    const { product } = usePage<{product: Product}>().props;
    const { data, setData, post, processing, errors } = useForm<Required<ProductForm>>({
        name: product.name,
        description: product.description,
        image: null,
        price: product.price,
        stock: product.stock,
        discount: product.discount,
        is_active: product.is_active,
    });

    const handleSubmit = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route('admin.products.update', {product: product.id}), {preserveScroll: true});
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
          <Head title="Edit Product" />
          <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h1 className="text-2xl font-bold">Edit Product</h1>
            <form className="flex flex-col gap-6" onSubmit={handleSubmit} encType="multipart/form-data">
              <div className="flex flex-col gap-6">
                <div className="flex flex-col gap-2">
                  <Label htmlFor="name">Name</Label>
                  <Input id="name" type="text" value={data.name} onChange={(e) => setData('name', e.target.value)} />
                  <InputError message={errors.name} />
                </div>
                <div className="flex flex-col gap-2">
                  <Label htmlFor="description">Description</Label>
                  <Textarea id="description" value={data.description} onChange={(e) => setData('description', e.target.value)} />
                  <InputError message={errors.description} />
                </div>
                <div className="flex flex-col gap-2">
                  <div className="flex gap-2 items-center">
                    <div className="flex flex-col items-center">
                      <img src={data.image ? URL.createObjectURL(data.image) : `/storage/products/${product.image}`} alt={product.name} className="w-24 rounded-md" />
                      <p className="text-xs text-gray-500">Image</p>
                    </div>
                    {
                      data.image && (
                        <div className="flex flex-col items-center">
                          <img src={`/storage/products/${product.image}`} alt={product.name} className="w-24 rounded-md" />
                          <p className="text-xs text-gray-500">Old image</p>
                        </div>
                      )
                    }
                  </div>
                  <Label htmlFor="image">Image</Label>
                  <Input id="image" type="file" onChange={(e) => setData('image', e.target.files?.[0] ?? null)} />
                  <InputError message={errors.image} />
                </div>
                <div className="flex flex-col gap-2">
                  <Label htmlFor="price">Price</Label>
                  <Input id="price" type="number" value={data.price} onChange={(e) => setData('price', Number(e.target.value))} />
                  <InputError message={errors.price} />
                </div>
                <div className="flex flex-col gap-2">
                  <Label htmlFor="stock">Stock</Label>
                  <Input id="stock" type="number" value={data.stock} onChange={(e) => setData('stock', Number(e.target.value))} />
                  <InputError message={errors.stock} />
                </div>
                <div className="flex flex-col gap-2">
                  <Label htmlFor="discount">Discount</Label>
                  <Input id="discount" type="number" value={data.discount} onChange={(e) => setData('discount', Number(e.target.value))} />
                  <InputError message={errors.discount} />
                </div>
                <div className="flex flex-col gap-2">
                  <Label htmlFor="is_active">Status</Label>
                  <DropdownMenu>
                    <DropdownMenuTrigger asChild>
                      <Button variant="outline">{data.is_active ? 'Active' : 'Inactive'}</Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                      <DropdownMenuItem onClick={() => setData('is_active', true)}>Active</DropdownMenuItem>
                      <DropdownMenuItem onClick={() => setData('is_active', false)}>Inactive</DropdownMenuItem> 
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