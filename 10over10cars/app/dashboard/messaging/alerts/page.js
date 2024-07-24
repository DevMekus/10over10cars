import React from "react";

const page = () => {
  return (
    <div className="dash-page">
      <div className="card-primary">
        <h4 class="color-primary">Events & Notification</h4>
        <p className="color-grey">Manage all the events and notifications.</p>
      </div>
      <div>
        <div className="mt-10 padding-10 special-bg">
          <div className="alert-header">
            <div>
              <h5 className="color-white">System Upgrade</h5>
              <p className="color-grey moveup-10s small-p">July 12, 2012</p>
            </div>
          </div>
          <p className="color-white small-p">
            Google Fonts makes it easy to bring personality and performance to
            your websites and products.
          </p>
        </div>
      </div>
    </div>
  );
};

export default page;
