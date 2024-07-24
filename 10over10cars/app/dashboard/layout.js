import Sidebar from "@/components/Sidebar";
import NavigationBar from "@/components/NavigationBar";
import { dashUrl } from "@/library/navigation";
import DashboardNav from "@/components/DashboardNav";

const Layout = ({ children, currentUrl }) => {
  return (
    <>
      <div className="app-wrapper app-flex">
        <Sidebar links={dashUrl} />
        <div className="app-main-content">
          <DashboardNav breadcrumb={currentUrl} />
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
