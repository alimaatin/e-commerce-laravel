import { usePage } from "@inertiajs/react";

export default function PaymentFailed() {
  const { data } = usePage<{ data: any }>().props;
  return (
    <div>
      <h1>Payment Failed</h1>
      <h1>{JSON.stringify(data)}</h1>
    </div>
  );
}
