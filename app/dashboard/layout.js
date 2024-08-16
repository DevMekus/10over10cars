"use client";
import Sidebar from "@/components/Sidebar";
import { dashUrl } from "@/library/navigation";
import DashboardNav from "@/components-main/DashboardNav";
import { verifySessionRole } from "@/library/utils/sessionManager";
import GetCart from "@/app/libs/CartManager/GetCart";

const Layout = ({ children }) => {
  const { cart, setcart } = GetCart();
  // const path = location.href;

  // useEffect(() => {
  //   verifySessionRole(path);
  // }, []);

  return (
    <>
      <div className="app-wrapper app-flex">
        <Sidebar links={dashUrl} />
        <div className="app-main-content">
          <DashboardNav cart={cart} />
          <div className="mt-10">
            <div className="container">
              <div className="row">
                <div className="col-sm-12">{children}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Layout;
