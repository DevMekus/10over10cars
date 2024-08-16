import React from "react";
import Link from "next/link";

const Footer = () => {
  return (
    <>
      <footer className="container section-padding">
        <div className="row">
          <div className="col-sm-12">
            <h1 className="section-title-bg">
              10over10 <span className="color-primary">Cars</span>
            </h1>
            <p>
              We provide everything you need to build an amazing dealership.
            </p>
            <p>1635 Franklin Street Montgomery, Near Sherwood Mall. AL 36104</p>
          </div>
        </div>
        <div className="mt-10">
          <div className="row">
            <div className="col-sm-4">
              <h4>Newsletter</h4>
              <p>
                To get all the relevant information about our services and
                offer, <br />
                subscribe to our newsletters.
              </p>

              <div className="ctr-wrapper ">
                <form className="flex gap-10 f-width align-center">
                  <div className="col-sm-8">
                    <input
                      className="form-input form-ctr ctr-no-bg"
                      type="text"
                      placeholder="Ex: You@email.com"
                      required
                    />
                  </div>
                  <button className="button button-primary radius-5">
                    Send
                  </button>
                </form>
              </div>
            </div>
            <div className="col-sm-4">
              <h4>Socials</h4>
              <p>
                Follow our social media pages for more exciting photos and
                information
              </p>
              <div className="social-links">
                <Link href="/">
                  <i class="fab fa-facebook-square icon" aria-hidden="true"></i>
                </Link>
                <Link href="/">
                  <i class="fab fa-twitter-square icon" aria-hidden="true"></i>
                </Link>
                <Link href="/">
                  <i class="fab fa-instagram icon" aria-hidden="true"></i>
                </Link>
                <Link href="/">
                  <i class="fab fa-linkedin icon" aria-hidden="true"></i>
                </Link>
              </div>
            </div>
            <div className="col-sm-4">
              <h4>Useful links</h4>
              <div className="mt-15">
                <Link className="footer-link" href="/">
                  <p>
                    <i
                      class="fas fa-long-arrow-right mr-10"
                      aria-hidden="true"
                    ></i>{" "}
                    Change Oil & Filter
                  </p>
                </Link>
                <Link className="footer-link" href="/">
                  <p>
                    <i
                      class="fas fa-long-arrow-right mr-10"
                      aria-hidden="true"
                    ></i>{" "}
                    Brake Pads Replacement
                  </p>
                </Link>
              </div>
              <p>For enquiries and</p>
              <div>
                <h4>Download Now On :</h4>
                <div className="flex gap-10">
                  <button className="button button-danger radius-5">
                    <i
                      className="fab fa-apple download-icon mr-10"
                      aria-hidden="true"
                    ></i>
                    <span className="color-white">Apple Store</span>
                  </button>
                  <button className="button button-dark radius-5">
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
      </footer>
    </>
  );
};

export default Footer;
