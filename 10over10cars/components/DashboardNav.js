"use client";
import React from "react";
import Link from "next/link";
import { useEffect, useState } from "react";

const DashboardNav = () => {
  const [isScrolled, setisScrolled] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      const scrollTop = window.pageYOffset;

      if (scrollTop > 0) {
        setisScrolled(true);
      } else {
        setisScrolled(false);
      }
    };

    window.addEventListener("scroll", handleScroll);

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);
  return (
    <>
      <div className="dash-nav-wrapper">
        <div className="inner">
          <div className="site-maps">
            <h5 class="color-primary bold">Good afternoon John,</h5>
            <p className="color-grey small-p">Last login: Wed, Oct 20, 2021</p>
          </div>
          <div className="icons nav-icon">
            <div className="filter-box">
              <span class="material-symbols-outlined t-nav-icon">
                travel_explore
              </span>
              <div className="top-filter nav-drop padding-10">
                <p className="color-grey small-p">Search & filter products</p>
                <div className="ctr-wrapper">
                  <label className="color-primary">Search product</label>
                  <input
                    className="form-input form-ctr ctr-no-bg"
                    type="text"
                    placeholder="Ex: Toyota Camry"
                    required
                  />
                </div>
                <div className="search-results mt-20">
                  <p className="color-grey small-p">Search results...</p>
                </div>
              </div>
            </div>
            <div className="account">
              <span class="material-symbols-outlined">account_circle</span>
              <div className="account-drop nav-drop padding-10">
                <h5 className="color-primary">Account</h5>
                <Link href="/dashboard" className="link">
                  <p>Profile</p>
                </Link>
                <p className="color-grey moveup-10 small-p">
                  Manage your account profile.
                </p>
                <Link href="/dashboard" className="link">
                  <p>Settings & preference</p>
                </Link>
                <div className="flex gap-10 align-center f-width">
                  <p className="color-grey small-p mt-10">Logout safely.</p>
                  <button className="button button-danger radius-5">
                    <i className="fas fa-power-off mr-10"></i>Logout
                  </button>
                </div>
              </div>
            </div>
            <div className="cart">
              <span class="material-symbols-outlined">shopping_cart</span>
              <div className="cart-drop nav-drop padding-10">
                <h5 className="color-primary">Shopping cart</h5>
                <p className="color-grey small-p">
                  Your cart is empty at the moment
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default DashboardNav;
