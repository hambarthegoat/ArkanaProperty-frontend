import { RouterProvider } from "react-router";
// Verified router import
import { router } from "./router";

export default function App() {
  return <RouterProvider router={router} />;
}
