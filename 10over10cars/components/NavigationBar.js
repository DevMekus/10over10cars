import React from "react";
import Breadcrumb from "./Breadcrumb";

const NavigationBar = ({ breadcrumb }) => {
  return (
    <>
      <div>
        <div className="nav-container">
          <nav className="navbar">
            <div className="site-map">
              <h5 class="color-primary bold">Hello, James</h5>
              <p className="color-grey moveup-10">
                Last login: Wed, Oct 20, 2021
              </p>
            </div>
            <div className="flex gap-10 align-center">
              <div className="nav-icon">
                <span className="material-symbols-outlined icon">
                  notifications
                </span>
                <span
                  className="material-symbols-outlined icon"
                  title="Pull our Cart"
                >
                  shopping_cart
                </span>
              </div>
              <div className="special-bg padding-10 flex gap-10 radius-5 pointer">
                <span className="material-symbols-outlined icon color-primary">
                  person
                </span>
                <span className="">
                  <span className="color-grey">
                    Andrew{" "}
                    <span className="color-green">
                      <em>(Admin)</em>
                    </span>
                  </span>
                </span>
              </div>
            </div>
          </nav>
        </div>
      </div>
    </>
  );
};

export default NavigationBar;
