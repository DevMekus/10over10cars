import React from "react";

const RegisterVin = () => {
  return (
    <>
      <div className="wrapper padding-10">
        <h5 className="color-white">Vehicle Information</h5>
        <p className="color-grey moveup-10">
          To begin this process, register a Vn
        </p>
        <div className="col-sm-5 moveup-10">
          <div className="ctr-wrapper">
            <input
              className="form-input form-ctr .ctr-no-bg"
              type="text"
              placeholder="Ex: 378HJKS373GH"
              required
            />
          </div>
        </div>
        <button className="button button-primary radius-5 mt-10">
          Get started
        </button>
      </div>
    </>
  );
};

export default RegisterVin;
