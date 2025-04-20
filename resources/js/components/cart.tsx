import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from "@/components/ui/sheet";
import { Button, buttonVariants } from "./ui/button";
import { ShoppingCartIcon, Trash2Icon } from "lucide-react";
import { useCart } from "@/context/cart-context";
import { Link } from "@inertiajs/react";
import { cn } from "@/lib/utils";

export default function Cart() {
    const { items, removeFromCart, incrementQuantity, decrementQuantity, totalPrice, totalItems } = useCart();

    const formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
    });

    return (
      <Sheet>
        <SheetTrigger>
          <div className="relative hover:opacity-80 transition">
            <ShoppingCartIcon size={25}/>
            {items.length > 0 && <span className="absolute bottom-3 left-4 bg-red-500 text-white rounded-full w-4 h-4 text-xs">{totalItems}</span>}
          </div>
        </SheetTrigger>
        <SheetContent>
          <SheetHeader>
            <SheetTitle>Cart</SheetTitle>
          </SheetHeader>
          <div className="flex flex-col gap-4 p-4 justify-between h-full">
            {items.length === 0 ?
              <p>No items in cart</p>
             :
             <div className="flex flex-col gap-2 overflow-y-auto">
              {
              items.map((item) => (
                <div key={item.id}>
                  <div className="flex items-center justify-between p-4 border rounded-lg">
                    <div className="flex items-center gap-2">
                      <img src={`/storage/products/${item.image}`} alt={item.name} className="w-16 h-16 rounded-md object-cover" />
                      <div className="flex flex-col">
                        <h3 className="font-medium flex items-center gap-2">{item.name}<button className="hover:text-red-500" onClick={() => removeFromCart(item.id)}><Trash2Icon size={15} /></button></h3>
                        <div className="flex flex-col text-sm text-gray-500">
                          <p>{formatter.format(item.price)} each</p>
                          <p className="font-medium">{formatter.format(item.price * item.quantity)} total</p>
                        </div>
                      </div>
                    </div>
                    <div className="flex items-center gap-2">
                      <Button 
                        variant="outline" 
                        size="sm"
                        onClick={() => decrementQuantity(item.id)}
                      >
                        -
                      </Button>
                      <span>{item.quantity}</span>
                      <Button
                        variant="outline"
                        size="sm" 
                        onClick={() => incrementQuantity(item.id)}
                        disabled={item.quantity >= item.stock}
                      >
                        +
                      </Button>
                    </div>
                  </div>
                </div>
              ))}
              </div>
              }
              <div className="flex flex-col gap-4">
                <div className="flex justify-between items-center border-t pt-4">
                  <span className="font-medium">Total ({totalItems} items):</span>
                  <span className="font-bold text-lg">{formatter.format(totalPrice)}</span>
                </div>
                <Link href="/checkout" className={cn(buttonVariants({ variant: "default" }), "w-full")}>Checkout</Link>
              </div>
          </div>
        </SheetContent>
      </Sheet>
    );
}
