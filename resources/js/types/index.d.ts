import { LucideIcon } from 'lucide-react';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
    [key: string]: unknown;
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    role: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface Member {
    vendor_id: number;
    user_id: number;
    status: string | null;
    user: User;
}

export interface Product {
    id: number;
    name: string;
    description: string;
    image: string;
    price: number;
    stock: number;
    discount: number;
    discounted_price: number;
    is_active: boolean;
}

export interface ProductForm {
    name: string;
    description: string;
    image: File | null;
    price: number;
    stock: number;
    discount: number;
    is_active?: boolean;
    vendor: number;
}

export interface EditUserForm {
    role: string;
}

export interface CartItem {
    id: number;
    name: string;
    price: number;
    quantity: number;
    image: string;
    stock: number;
}

export interface Order {
    id: number;
    name: string;
    email: string;
    address: string;
    status: string;
    total_price: number;
    user_id: number;
    postal_code: string;
    order_details: OrderDetail[];
    created_at: Date;
    updated_at: Date;
}

export interface OrderDetail {
    id: number;
    order_id: number;
    product_id: number;
    quantity: number;
    price: number;
    product: Product;
}

export interface PaymentSuccess {
    code: number;
    message: string;
    card_hash: string;
    card_pan: string;
    ref_id: number;
    fee: number;
    fee_type: number;
}

export interface PaymentResponse {
    data: PaymentSuccess;
    errors: [];
}

export interface Vendor {
    id: number;
    name: string;
    owner_id: number;
    owner_name: string;
    status: string;
    created_at: Date;
    updated_at: Date;
}

export interface Reservation {
  id: number;
  vendor_id: number;
  name: string;
  summary: string;
  description: string;
  price: number;
  start: string; // datetime (ISO format)
  end: string;
  off_days: string[]; // array of day names e.g. ['Friday', 'Saturday']
  exp_date: string; // date
  status: boolean;
  created_at: string;
  updated_at: string;
}

export interface ReservationForm {
  name: string;
  summary: string;
  description: string;
  start: string;
  end: string;
  price: number;
  off_days: string[];
  exp_date: string;
  status: boolean;
  vendor_id: number;
}

export interface InvitationAction {
    accept: string;
    decline: string;
}

export interface Notification {
    id: number;
    is_read: boolean;
    action_taken: boolean;
    message: string;
    reference_id: number;
    reference_type: string;
    user_id: number;
}
