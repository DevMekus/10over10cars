import React from "react";

const page = () => {
  return (
    <>
      <div className="dash-page">
        <div className="card-primary f-width flex align-center gap-20">
          <div>
            <h4 class="color-primary">Account Activation Failed</h4>
            <p className="color-grey moveup-10">
              Support conversations: (
              <span className="color-primary">#379HI829</span>)
            </p>
            <p className="color-grey moveup-10">
              Support is: <span className="color-green bold">OPEN</span>
            </p>
          </div>
          <div className="col-sm-2">
            <select className="form-input form-ctr ctr-no-bg radius-5">
              <option>Open</option>
              <option>Close</option>
              <option>Pending</option>
            </select>
          </div>
        </div>
        <div className="support-conversation mt-10">
          <div className="support-message-well scrollable mt-10">
            <div className="special-bg padding-10">
              <h5 className="color-green">John Doe</h5>
              <p className="color-grey moveup-10">July 12, 2021 13:18 pm.</p>
              <p className="color-white">
                Google Fonts makes it easy to bring personality and performance
                to your websites and products. Our robust catalog of open-source
                fonts and icons makes it easy to integrate expressive type and
                icons seamlessly — no matter where you are in
              </p>
            </div>
            <div className="special-bg padding-10 mt-10">
              <h5 className="color-red">Admin</h5>
              <p className="color-grey moveup-10">July 12, 2021 13:18 pm.</p>
              <p className="color-white">
                Google Fonts makes it easy to bring personality and performance
                to your websites and products. Our robust catalog of open-source
                fonts and icons makes it easy to integrate expressive type and
                icons seamlessly — no matter where you are in
              </p>
            </div>
          </div>
          <div className="special-bg mt-10">
            <div className="support-textbox-area ">
              <div>
                <textarea
                  rows={3}
                  placeholder="Write your message here"
                  className="form-input form-ctr ctr-no-bg radius-5"
                ></textarea>
              </div>
              <button className="button button-primary radius-5">
                Send <i className="fas fa-comment"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
