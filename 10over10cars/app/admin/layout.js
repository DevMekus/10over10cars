import Sidebar from "@/components/Sidebar";
import NavigationBar from "@/components/NavigationBar";
import { adminUrl } from "@/library/navigation";

const Layout = ({ children, currentUrl }) => {
  return (
    <>
      <div className="app-wrapper app-flex">
        <Sidebar links={adminUrl} />
        <div className="app-main-content">
          <NavigationBar breadcrumb={currentUrl} />
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
