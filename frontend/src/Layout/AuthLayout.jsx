import { Outlet } from "react-router-dom";

export default function AuthLayout() {
  return (
     <main className='overflow-x-hidden bg-white text-dark min-h-screen flex flex-col'>
      <main className='flex-grow'>
        <Outlet />
      </main>
    </main>
  );
}