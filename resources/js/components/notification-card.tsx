import { Notification } from "@/types";
import { Button } from "./ui/button";

interface NotificationCardProps {
  notification: Notification;
}

const getActions = (reference_type: string, reference_id: number) => {
  switch (reference_type) {
    case 'App\\Models\\VendorInvitation':
      return { 
        accept: route('vendor.accept', reference_id),
        decline: route('vendor.decline', reference_id),
      }
  }
}

export default function NotificationCard({ notification }: NotificationCardProps) {
  const actions = getActions(notification.reference_type, notification.reference_id);
  return(
    <div className="space-y-4 rounded-md border p-4">
      <h2>Notification</h2>
      <p>{notification.message}</p>
      {actions && (
        <div className="flex gap-2">
          {'accept' in actions && (
            <form method="POST" action={actions.accept}>
              <Button type="submit">Accept</Button>
            </form>
          )}
          
          {'decline' in actions && (
            <form method="POST" action={actions.decline}>
              <Button type="submit" variant={"secondary"}>Decline</Button>
            </form>
          )}
        </div>
      )}
    </div>
  );
}