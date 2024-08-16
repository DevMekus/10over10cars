"use client";
import React from "react";
import Link from "next/link";
import { useEffect, useState } from "react";
import { objectFromFormdata } from "@/library/utils/Utility";
import { fetchData } from "@/library/utils/fetchData";
import { sessionManager } from "@/library/utils/sessionManager";
import Cart from "@/components-main/Cart";

const FrontNav = () => {
  const [isScrolled, setisScrolled] = useState(false);
  const [error, setError] = useState(null);
  const [success, setSuccess] = useState(null);

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

  async function handleLogin(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    const data = objectFromFormdata(formData);

    try {
      const user = await fetchData("account", "POST", data);

      if (user["status"] == "error") {
        setError(user["message"]);
      } else {
        setSuccess(user["message"]);
        const sessionData = {
          userid: user.userid,
          role: user.role,
        };
        sessionStorage.setItem("user", JSON.stringify(sessionData));
        sessionManager(sessionData);
      }
    } catch (error) {
      setError(error.message);
    }
  }

  return (
    <>
      <div className="nav-wrapper">
        <div className="nav-inner">
          <div className="nav-section">
            <Link href="/">
              <img
                src="/logo-black-edit.jpg"
                alt="logo"
                className="img-fluid nav-logo"
              />
            </Link>
          </div>
          <div
            className={`nav-section link-section ${
              isScrolled ? `scroll-white` : ``
            }`}
          >
            <div>
              <div className="nav-pages">
                <div className="link-wrap">
                  <Link href="/" className="link top-link">
                    Home
                  </Link>
                </div>
                <div className="link-wrap show-company">
                  <Link href="/" className="link top-link">
                    Company <i className="fas fa-caret-down ml-10"></i>
                  </Link>
                  <div className="company-drop drop-section">
                    <div className="container padding-20">
                      <div className="row">
                        <div className="col-sm-3">
                          <h5 className="color-primary">Company</h5>
                          <div>
                            <Link href="/about" className="drop-link">
                              About us
                            </Link>
                          </div>
                          <div>
                            <Link href="/services" className="drop-link">
                              Our services
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="drop-link">
                              Career
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="drop-link">
                              Team
                            </Link>
                          </div>
                        </div>
                        <div className="col-sm-3">
                          <h5 className="color-primary">Useful links</h5>
                          <div>
                            <Link href="/pricing" className="drop-link ">
                              Pricing
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="drop-link">
                              Frequently asked?
                            </Link>
                          </div>
                          <div>
                            <Link href="/contact" className="drop-link">
                              Contact us
                            </Link>
                          </div>
                        </div>
                        <div className="col-sm-3">
                          <h5 className="color-primary">Policy</h5>
                          <div>
                            <Link href="/" className="drop-link">
                              Privacy policy
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="drop-link">
                              Terms & condition
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="drop-link">
                              Sample verification
                            </Link>
                          </div>
                        </div>
                        <div className="col-sm-3">
                          <h5 className="color-primary">Download</h5>
                          <p className="color-grey small-p">
                            Download Our Car Dealer Verification Application.
                          </p>
                          <button className="button button-danger radius-5">
                            <i
                              className="fab fa-apple download-icon mr-10"
                              aria-hidden="true"
                            ></i>
                            <span className="color-white">Apple Store</span>
                          </button>
                          <button className="button download-button-dark radius-5 mt-10">
                            <i
                              className="fab fa-android download-icon mr-10"
                              aria-hidden="true"
                            ></i>
                            <span className="color-white">Google Play</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div className="link-wrap">
                  <Link href="/" className="link">
                    Gallery
                  </Link>
                </div>
              </div>
            </div>
            <div className="icons nav-icon">
              <div className="filter-box">
                <span className="material-symbols-outlined t-nav-icon">
                  travel_explore
                </span>
                <div className="top-filter padding-10">
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
                <span className="material-symbols-outlined">
                  account_circle
                </span>
                <div className="account-drop padding-10">
                  <h5 className="color-primary">Account login</h5>
                  <p className="color-white small-p">
                    Log into your account and enjoy more.
                  </p>
                  {error && <p className="color-red">{error}</p>}
                  {success && <p className="color-green">{success}</p>}
                  <form onSubmit={handleLogin}>
                    <div className="ctr-wrapper">
                      <label className="color-grey">Email address</label>
                      <input
                        className="form-input form-ctr ctr-no-bg"
                        type="text"
                        placeholder="Ex: You@email.com"
                        name="email_address"
                        required
                      />
                    </div>
                    <div className="ctr-wrapper">
                      <label className="color-grey">Password</label>
                      <input
                        className="form-input form-ctr ctr-no-bg"
                        type="password"
                        name="user_password"
                        placeholder="Enter password"
                        required
                      />
                    </div>
                    <input type="hidden" name="action" value="LOGIN" />
                    <div className="f-width flex flex-start mt-10s">
                      <Link
                        className="no-decoration pointer"
                        href="/auth/reset"
                      >
                        <label className="color-grey pointer">
                          Forgot password?
                        </label>
                      </Link>
                    </div>
                    <div className="f-width flex space-between align-center mt-10">
                      <Link href="/auth/new" className="no-decoration link">
                        Create account
                      </Link>
                      <button
                        type="submit"
                        className="button button-primary radius-5"
                      >
                        Login
                      </button>
                    </div>
                  </form>
                </div>
              </div>
              <Cart />
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default FrontNav;
