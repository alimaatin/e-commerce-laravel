import { createContext, useContext, useState, useEffect } from "react";
import { CartItem } from "@/types";

type CartContextType = {
    items: CartItem[];
    addToCart: (item: CartItem) => boolean;
    removeFromCart: (id: number) => void;
    clearCart: () => void;
    totalPrice: number;
    totalItems: number;
    updateQuantity: (id: number, quantity: number) => boolean;
    incrementQuantity: (id: number) => boolean;
    decrementQuantity: (id: number) => void;
};

const CART_STORAGE_KEY = 'shopping_cart';

const CartContext = createContext<CartContextType | undefined>(undefined);

export function CartProvider({ children }: { children: React.ReactNode }) {
    const [items, setItems] = useState<CartItem[]>(() => {
        const savedCart = localStorage.getItem(CART_STORAGE_KEY);
        if (savedCart) {
            try {
                return JSON.parse(savedCart);
            } catch (error) {
                console.error('Failed to parse cart from localStorage', error);
                return [];
            }
        }
        return [];
    });

    useEffect(() => {
        localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(items));
    }, [items]);

    const addToCart = (item: CartItem): boolean => {
        setItems(currentItems => {
            const existingItem = currentItems.find(cartItem => cartItem.id === item.id);
            
            if (existingItem) {
                if (existingItem.quantity + item.quantity > item.stock) {
                    return currentItems;
                }
                return currentItems.map(cartItem => 
                    cartItem.id === item.id 
                        ? { 
                            ...cartItem, 
                            quantity: cartItem.quantity + item.quantity,
                            price: item.price
                          }
                        : cartItem
                );
            }
            
            if (item.quantity > item.stock) {
                return currentItems;
            }
            
            return [...currentItems, item];
        });
        return true;
    };

    const removeFromCart = (id: number) => {
        setItems(items => items.filter((item) => item.id !== id));
    };

    const clearCart = () => {
        setItems([]);
        localStorage.removeItem(CART_STORAGE_KEY);
    };

    const updateQuantity = (id: number, quantity: number): boolean => {
        if (quantity <= 0) {
            removeFromCart(id);
            return true;
        }

        const item = items.find(item => item.id === id);
        if (!item || quantity > item.stock) {
            return false;
        }

        setItems(currentItems =>
            currentItems.map(item =>
                item.id === id ? { ...item, quantity } : item
            )
        );
        return true;
    };

    const incrementQuantity = (id: number): boolean => {
        const item = items.find(item => item.id === id);
        if (!item || item.quantity >= item.stock) {
            return false;
        }

        setItems(currentItems =>
            currentItems.map(item => {
                if (item.id === id) {
                    return {
                        ...item,
                        quantity: item.quantity + 1,
                        price: item.price
                    };
                }
                return item;
            })
        );
        return true;
    };

    const decrementQuantity = (id: number) => {
        setItems(currentItems =>
            currentItems.map(item => {
                if (item.id === id) {
                    if (item.quantity <= 1) {
                        removeFromCart(id);
                        return item;
                    }
                    return {
                        ...item,
                        quantity: item.quantity - 1,
                        price: item.price
                    };
                }
                return item;
            })
        );
    };

    const totalPrice = items.reduce((acc, item) => acc + item.price * item.quantity, 0);
    const totalItems = items.reduce((acc, item) => acc + item.quantity, 0);

    return (
        <CartContext.Provider 
            value={{ 
                items, 
                addToCart, 
                removeFromCart, 
                clearCart, 
                totalPrice, 
                totalItems,
                updateQuantity,
                incrementQuantity,
                decrementQuantity
            }}
        >
            {children}
        </CartContext.Provider>
    );
}

export function useCart() {
    const context = useContext(CartContext);
    if (!context) {
        throw new Error('useCart must be used within a CartProvider');
    }
    return context;
}
