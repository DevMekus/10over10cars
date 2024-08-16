import React from "react";
import ManageFeature from "@/components/ModalComponents/ManageFeature";
const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Feature Management</h4>
          <p className="color-grey">
            Manage all the features of the vehicle verification.
          </p>
          <div>
            <ManageFeature />
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
