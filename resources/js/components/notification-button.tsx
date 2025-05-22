import { Link } from "@inertiajs/react";
import { Bell } from "lucide-react";

export default function NotificationButton() {
  return(
    <div>
      <Link href={route('notifications')} className="relative hover:opacity-75 transition-all">
        <p className="absolute bottom-3 left-2 bg-red-500 text-white rounded-full w-4 h-4 text-xs text-center scale-90">2</p>
        <Bell size={20} color="gray"/>  
      </Link>
    </div>
  );
}