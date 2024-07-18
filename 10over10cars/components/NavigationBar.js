import React from "react";
import Breadcrumb from "./Breadcrumb";

const NavigationBar = ({ breadcrumb }) => {
  return (
    <>
      <div>
        <div className="nav-container">
          <nav className="navbar">
            <div className="site-map">
              <p>{breadcrumb}</p>
            </div>
            <div className="nav-icon">
              <span className="material-symbols-outlined icon">
                notifications
              </span>
              <span className="material-symbols-outlined icon">
                account_circle
              </span>
              <span
                className="material-symbols-outlined icon"
                title="Pull our Cart"
              >
                shopping_cart
              </span>
            </div>
          </nav>
        </div>
      </div>
    </>
  );
};

export default NavigationBar;
