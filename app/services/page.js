import React from "react";
import FrontNav from "@/components/FrontNav";
import Footer from "@/components/Footer";

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
                  Services <span className="color-green">in the company</span>
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
          <div class="row border-bottom">
            <div className="col-sm-4">
              <div className="service">
                <div className="service-icon">
                  <img
                    className="img-fluid"
                    src="https://cdn3.iconfinder.com/data/icons/miscellaneous-326-line-15/128/surveys_observe_view_inspection_check_inquiry_oversight_investigation_review-256.png"
                    alt="service-icon"
                  />
                </div>
                <h4 className="mt-15 text-center">Super Fast</h4>
                <p className="text-center">
                  Galley of bled it lorem Ipsum is simply dummy text of the k a
                  to make a type book. but also the leap into electronic
                  typesetting.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              <div className="service border-left border-right">
                <div className="service-icon">
                  <img
                    className="img-fluid"
                    src="https://cdn3.iconfinder.com/data/icons/miscellaneous-326-line-15/128/surveys_observe_view_inspection_check_inquiry_oversight_investigation_review-256.png"
                    alt="service-icon"
                  />
                </div>
                <h4 className="mt-15 text-center">Super Fast</h4>
                <p className="text-center">
                  Galley of bled it lorem Ipsum is simply dummy text of the k a
                  to make a type book. but also the leap into electronic
                  typesetting.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              {" "}
              <div className="service">
                <div className="service-icon">
                  <img
                    className="img-fluid"
                    src="https://cdn3.iconfinder.com/data/icons/miscellaneous-326-line-15/128/surveys_observe_view_inspection_check_inquiry_oversight_investigation_review-256.png"
                    alt="service-icon"
                  />
                </div>
                <h4 className="mt-15 text-center">Super Fast</h4>
                <p className="text-center">
                  Galley of bled it lorem Ipsum is simply dummy text of the k a
                  to make a type book. but also the leap into electronic
                  typesetting.
                </p>
              </div>
            </div>
          </div>
          <div class="row">
            <div className="col-sm-4">
              <div className="service">
                <div className="service-icon">
                  <img
                    className="img-fluid"
                    src="https://cdn3.iconfinder.com/data/icons/miscellaneous-326-line-15/128/surveys_observe_view_inspection_check_inquiry_oversight_investigation_review-256.png"
                    alt="service-icon"
                  />
                </div>
                <h4 className="mt-15 text-center">Super Fast</h4>
                <p className="text-center">
                  Galley of bled it lorem Ipsum is simply dummy text of the k a
                  to make a type book. but also the leap into electronic
                  typesetting.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              <div className="service border-left border-right">
                <div className="service-icon">
                  <img
                    className="img-fluid"
                    src="https://cdn3.iconfinder.com/data/icons/miscellaneous-326-line-15/128/surveys_observe_view_inspection_check_inquiry_oversight_investigation_review-256.png"
                    alt="service-icon"
                  />
                </div>
                <h4 className="mt-15 text-center">Super Fast</h4>
                <p className="text-center">
                  Galley of bled it lorem Ipsum is simply dummy text of the k a
                  to make a type book. but also the leap into electronic
                  typesetting.
                </p>
              </div>
            </div>
            <div className="col-sm-4">
              {" "}
              <div className="service">
                <div className="service-icon">
                  <img
                    className="img-fluid"
                    src="https://cdn3.iconfinder.com/data/icons/miscellaneous-326-line-15/128/surveys_observe_view_inspection_check_inquiry_oversight_investigation_review-256.png"
                    alt="service-icon"
                  />
                </div>
                <h4 className="mt-15 text-center">Super Fast</h4>
                <p className="text-center">
                  Galley of bled it lorem Ipsum is simply dummy text of the k a
                  to make a type book. but also the leap into electronic
                  typesetting.
                </p>
              </div>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-6">
              <div className="f-width">
                <img
                  alt="page-image"
                  className="img-fluid page-image"
                  src="https://themes.potenzaglobalsolutions.com/react/car-dealer/static/media/services-img2.f4efb7964b1a300c5fd1.webp"
                />
              </div>
            </div>
            <div className="col-sm-6">
              <div className="welcome-note">
                <h4 className="text-center color-grey">10over10 Cars</h4>
                <h1 className="section-title-bg text-center">
                  We provide best services Process
                </h1>
                <div className="mt-15">
                  <div className="hr hr_1"></div>
                  <div className="hr hr_2 mt-2"></div>
                </div>
              </div>
              <p>
                Dealer obcaecati adipisci vero lorem ipsum dolor sit amet,
                consectetur adipisicing elit. dolorum pariatur aut consectetur.
                Sit quisquam rerum corporis neque atque inventore nulla,
                quibusdam, ipsa suscipit aperiam reiciendis, ea odio?
              </p>
              <p>
                Adipisicing ipsum dolor sit amet, consectetur elit. Obcaecati
                adipisci vero dolorum pariatur aut consectetur. Sit quisquam
                rerum corporis neque atque inventore nulla, quibusdam, ipsa
                suscipit aperiam reiciendis, ea odio?
              </p>
            </div>
          </div>
        </section>
        <Footer />
      </section>
    </>
  );
};

export default page;
