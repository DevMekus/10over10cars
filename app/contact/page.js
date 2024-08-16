import React from "react";
import FrontNav from "@/components/FrontNav";
import Footer from "@/components/Footer";
import Link from "next/link";

const page = () => {
  return (
    <>
      <section className="page-wrapper">
        <FrontNav />
        <section className="page-hero">
          <div className="container flex">
            <div className="hero-side hero-side-a">
              <div>
                <h1 className="hero-title">
                  Have Questions?{" "}
                  <span className="color-green">Contact us</span>
                </h1>
                <p className="color-white">
                  We provide everything you need to build an Amazing dealership{" "}
                </p>
              </div>
            </div>
            <div className="hero-side hero-side-img"></div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-8">
              <h1 className="section-title-bg">
                Have Questions? <br />
                <span className="color-primary">Get In Touch!</span>
              </h1>
            </div>
            <div className="col-sm-4">
              <p>
                Great! We’re excited to hear from you and let’s start something
                special togerter. call us for any inquery.
              </p>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-7">
              <div className="contact-form-area">
                <div>
                  <h4 className="color-red">Get in touch</h4>
                  <div></div>
                </div>
                <div className="mt-15">
                  <h1>Send A Message</h1>
                  <p>
                    Our experts and developers would love to contribute their
                    expertise and insights to your potencial projects
                  </p>
                </div>
                <form className="contact-form">
                  <div className="row">
                    <div className="col-sm-6">
                      <input
                        type="text"
                        className="form-input form-ctr ctr-no-bg"
                        placeholder="FullName *"
                      />
                    </div>
                    <div className="col-sm-6">
                      <input
                        type="email"
                        className="form-input form-ctr ctr-no-bg"
                        placeholder="Email Address *"
                      />
                    </div>
                  </div>
                  <div className="mt-15">
                    <div className="row">
                      <div className="col-sm-6">
                        <input
                          type="text"
                          className="form-input form-ctr ctr-no-bg"
                          placeholder="Phone Number *"
                        />
                      </div>
                      <div className="col-sm-6">
                        <input
                          type="text"
                          className="form-input form-ctr ctr-no-bg"
                          placeholder="Subject *"
                        />
                      </div>
                    </div>
                  </div>
                  <div className="mt-15">
                    <textarea
                      className="form-input form-ctr ctr-no-bg"
                      placeholder="Write your message..."
                      rows={6}
                    ></textarea>
                  </div>
                  <div className="mt-15">
                    <button className="button button-primary radius-5">
                      Send Your Message
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div className="col-sm-4">
              <div className="contact-information">
                <h1>Contact Details</h1>
                <p className="mt-15 color-white">
                  1635 Franklin Street Montgomery, Near Sherwood Mall. AL 36104
                </p>
                <div className="mt-15">
                  <p className="color-red">Send email</p>
                  <h4 className="color-white">Support@Example.Com</h4>
                </div>
                <div className="mt-15">
                  <p className="color-red">Call anytime</p>
                  <h4 className="color-white">(007) 123 456 7890</h4>
                </div>
                <div className="socials">
                  <div className="social">
                    <Link href="/">
                      <i
                        class="fab fa-facebook-square icon"
                        aria-hidden="true"
                      ></i>
                    </Link>
                  </div>
                  <div className="social">
                    <Link href="/">
                      <i
                        class="fab fa-twitter-square icon"
                        aria-hidden="true"
                      ></i>
                    </Link>
                  </div>
                  <div className="social">
                    <Link href="/">
                      <i class="fab fa-instagram icon" aria-hidden="true"></i>
                    </Link>
                  </div>
                  <div className="social">
                    <Link href="/">
                      <i class="fab fa-linkedin icon" aria-hidden="true"></i>
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section className="contact-steps container section-padding">
          <div className="row">
            <div className="col-sm-4">
              <div className="step">
                <div className="icon-flex">
                  <img
                    className="img-fluid"
                    src="https://cdn0.iconfinder.com/data/icons/office-set-9/512/5-256.png"
                    alt="step-icon"
                  />
                  <h3>Opening Hours</h3>
                </div>
                <p className="mt-15 text-center">
                  Voluptatem accusanoremque sed ut perspiciatis unde omnis iste
                  natus error sit laudantium.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              <div className="step">
                <div className="icon-flex">
                  <img
                    className="img-fluid"
                    src="https://cdn1.iconfinder.com/data/icons/seo-and-web-development-5/32/development_support_help_service_technical_support-256.png"
                    alt="step-icon"
                  />
                  <h3> Support Center</h3>
                </div>
                <p className="mt-15 text-center">
                  Voluptatem accusanoremque sed ut perspiciatis unde omnis iste
                  natus error sit laudantium.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              <div className="step">
                <div className="icon-flex">
                  <img
                    className="img-fluid"
                    src="https://cdn4.iconfinder.com/data/icons/music-ui-solid-24px/24/info_information_about_help-2-256.png"
                    alt="step-icon"
                  />
                  <h3>Some Information</h3>
                </div>
                <p className="mt-15 text-center">
                  Voluptatem accusanoremque sed ut perspiciatis unde omnis iste
                  natus error sit laudantium.
                </p>
              </div>
            </div>
          </div>
        </section>
        <Footer />
      </section>
    </>
  );
};

export default page;
