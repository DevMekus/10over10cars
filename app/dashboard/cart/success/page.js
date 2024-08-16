import React from "react";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="success-page">
          <div className="flex gap-20 align-center">
            <div className="inner-div special-bg">
              <h3 className="page-title color-primary text-center">
                TRANSACTION SUCCESS!
              </h3>
            </div>
            <div>
              <p className="color-white">
                To allow users to download the invoice as a PDF when they click
                a button in your Next.js application, you can use a library like{" "}
              </p>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
