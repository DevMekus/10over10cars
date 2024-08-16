"use client";
import React from "react";
import Link from "next/link";
import { useEffect, useState } from "react";
import { getSession } from "@/library/utils/sessionManager";
import { fetchData } from "@/library/utils/fetchData";
import { greetUser, formatTimestamp } from "@/library/utils/Utility";
import Cart from "@/components-main/Cart";

const DashboardNav = ({ userData }) => {
  const [isScrolled, setisScrolled] = useState(false);
  const [userInfo, setUserInfo] = useState([]);
  const [userName, setUserName] = useState([]);
  const [lastSeen, setLastSeen] = useState([]);
  const [cart, setCart] = useState([]);

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

  useEffect(() => {
    getSession().then((userid) => {
      if (userid) {
        user(userid);
      }
    });
  }, []);

  useEffect(() => {
    checkCart();
  }, []);

  function user() {
    let user = sessionStorage.getItem("data")
      ? JSON.parse(sessionStorage.getItem("data"))
      : [];
    setUserName(user[0]["fullname"]);
    setLastSeen(user[0]["last-seen"]);
  }

  function checkCart() {
    let cart = localStorage.getItem("cart")
      ? JSON.parse(localStorage.getItem("cart"))
      : [];

    setCart(cart);
  }

  return (
    <>
      <div className="dash-nav-wrapper">
        <div className="inner">
          <div className="welcome-message">
            <h5 className="bold">
              {greetUser()} {userName},
            </h5>
            <p className="small-p ls-2">
              <span className="bold">Last seen</span> {lastSeen}
            </p>
          </div>
          <div className="icons nav-icon">
            <div className="filter-box">
              <span className="material-symbols-outlined t-nav-icon">
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
              <span className="material-symbols-outlined t-nav-icon">
                account_circle
              </span>
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
            <Cart />
          </div>
        </div>
      </div>
    </>
  );
};

export default DashboardNav;
