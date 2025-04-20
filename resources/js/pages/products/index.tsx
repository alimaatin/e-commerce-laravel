import HomeLayout from '@/layouts/app/home-layout';
import { type Product } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import ProductCard from '@/components/product-card';
import { Input } from '@/components/ui/input';
import { Slider } from '@/components/ui/slider';
import { useState, useMemo } from 'react';

export default function Products() {
    const { products } = usePage<{ products: Product[] }>().props;
    const [search, setSearch] = useState('');
    const [priceRange, setPriceRange] = useState<[number, number]>([0, 1000]);

    const filteredProducts = useMemo(() => {
        return products.filter(product => {
            const matchesSearch = product.name.toLowerCase().includes(search.toLowerCase());
            const matchesPrice = product.price >= priceRange[0] && product.price <= priceRange[1];
            return matchesSearch && matchesPrice;
        });
    }, [products, search, priceRange]);

    const maxPrice = Math.max(...products.map(p => p.price));

    return (
        <HomeLayout>
            <Head title="Products" />
            <div className="container mx-auto px-4 py-8">
                <div className="mb-8 space-y-4">
                    <Input
                        placeholder="Search products..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        className="max-w-md"
                    />
                    <div className="max-w-md">
                        <div className="space-y-2">
                            <div className="flex justify-between text-sm text-muted-foreground">
                                <span>Price Range</span>
                                <span>${priceRange[0]} - ${priceRange[1]}</span>
                            </div>
                            <Slider
                                value={priceRange}
                                onValueChange={(value) => setPriceRange(value as [number, number])}
                                max={maxPrice}
                                step={1}
                                className="w-full"
                            />
                        </div>
                    </div>
                </div>
                <div className="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    {filteredProducts.map((product) => (
                        <ProductCard key={product.id} product={product} />
                    ))}
                </div>
                {filteredProducts.length === 0 && (
                    <div className="text-center py-12">
                        <p className="text-muted-foreground">No products found matching your criteria.</p>
                    </div>
                )}
            </div>
        </HomeLayout>
    );
}
