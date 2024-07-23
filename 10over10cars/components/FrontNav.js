"use client";
import React from "react";
import Link from "next/link";
import { useEffect, useState } from "react";

const FrontNav = () => {
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
      <div
        className={`nav-wrapper ${isScrolled ? "nav-scrolled" : "nav-default"}`}
      >
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
          <div className="nav-section link-section">
            <div>
              <div className="nav-pages">
                <div className="link-wrap">
                  <Link href="/" className="link">
                    Home
                  </Link>
                </div>
                <div className="link-wrap show-company">
                  <Link href="/" className="link">
                    Company <i className="fas fa-caret-down ml-10"></i>
                  </Link>
                  <div className="company-drop drop-section">
                    <div className="container padding-20">
                      <div className="row">
                        <div className="col-sm-3">
                          <h5>Company</h5>
                          <div>
                            <Link href="/" className="link">
                              About us
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Our services
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Career
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Team
                            </Link>
                          </div>
                        </div>
                        <div className="col-sm-3">
                          <h5>Useful links</h5>
                          <div>
                            <Link href="/" className="link">
                              Pricing
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Frequently asked?
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Contact us
                            </Link>
                          </div>
                        </div>
                        <div className="col-sm-3">
                          <h5>Policy</h5>
                          <div>
                            <Link href="/" className="link">
                              Privacy policy
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Terms & condition
                            </Link>
                          </div>
                          <div>
                            <Link href="/" className="link">
                              Sample verification
                            </Link>
                          </div>
                        </div>
                        <div className="col-sm-3">
                          <h5>Download</h5>
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
                          <button className="button button-dark radius-5 mt-10">
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
            <div className="icons">
              <div className="filter-box">
                <span class="material-symbols-outlined">travel_explore</span>
                <div className="top-filter padding-10">
                  <p className="color-grey small-p">Search & filter products</p>
                  <div className="ctr-wrapper">
                    <label className="color-black">Search report list</label>
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
                <div className="account-drop padding-10">
                  <h5>Account login</h5>
                  <p className="color-grey small-p">
                    Log into your account and enjoy more.
                  </p>
                  <form>
                    <div className="ctr-wrapper">
                      <label className="color-black">Email address</label>
                      <input
                        className="form-input form-ctr ctr-no-bg"
                        type="text"
                        placeholder="Ex: You@email.com"
                        required
                      />
                    </div>
                    <div className="ctr-wrapper">
                      <label className="color-black">Password</label>
                      <input
                        className="form-input form-ctr ctr-no-bg"
                        type="password"
                        placeholder=""
                        required
                      />
                    </div>
                    <div className="f-width flex flex-end mt-10s">
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
                      <button className="button button-primary radius-5">
                        Login
                      </button>
                      <Link href="/auth/new" className="no-decoration link">
                        Create account
                      </Link>
                    </div>
                  </form>
                </div>
              </div>
              <div className="cart">
                <span class="material-symbols-outlined">shopping_cart</span>
                <div className="cart-drop padding-10">
                  <h5>Shopping cart</h5>
                  <p className="color-grey small-p">
                    Your cart is empty at the moment
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default FrontNav;
