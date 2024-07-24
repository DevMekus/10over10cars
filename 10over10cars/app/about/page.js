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
                  About <span className="color-green">the company</span>
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
          <div className="welcome-note">
            <h4 className="text-center color-grey">Welcome</h4>
            <h1 className="section-title-bg text-center">The Car Verifier!</h1>
            <div className="mt-15">
              <div className="hr hr_primary hr_150"></div>
              <div className="hr hr_danger hr_200 mt-2"></div>
            </div>
          </div>
          <div className="mt-10">
            <p className="text-center">
              Car Dealer is the best premium HTML5 Template. We provide
              everything you need to build an Amazing dealership website
              developed especially for car sellers, dealers or auto motor
              retailers.
            </p>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-6">
              <div className="f-width">
                <img
                  alt="page-image"
                  className="img-fluid page-image"
                  src="https://images.unsplash.com/photo-1520587210458-bd3bee813b97?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                />
              </div>
            </div>
            <div className="col-sm-6">
              <h1 className="section-title-bg">
                Car <span className="color-primary">Dealer's Hub</span>
              </h1>
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
        <section className="container section-padding">
          <h4>Our value</h4>
          <h1 className="section-title-bg">
            Why Should You Use
            <br /> <span>Our Services?</span>
          </h1>
          <div className="values-wrapper mt-20">
            <div className="row">
              <div className="col-sm-3">
                <div className="value">
                  <div className="value-icon">
                    <span class="material-symbols-outlined icon">
                      account_balance_wallet
                    </span>
                  </div>
                  <div className="value-info">
                    <h4>Affordable</h4>
                    <p>Obcaecati adipisci vero dolorum pariatur</p>
                  </div>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="value">
                  <div className="value-icon">
                    <span class="material-symbols-outlined icon">
                      check_circle
                    </span>
                  </div>
                  <div className="value-info">
                    <h4>Verification</h4>
                    <p>Obcaecati adipisci vero dolorum pariatur</p>
                  </div>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="value">
                  <div className="value-icon">
                    <span class="material-symbols-outlined icon">
                      support_agent
                    </span>
                  </div>
                  <div className="value-info">
                    <h4>Free Support</h4>
                    <p>Obcaecati adipisci vero dolorum pariatur</p>
                  </div>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="value">
                  <div className="value-icon">
                    <span class="material-symbols-outlined icon">
                      brand_family
                    </span>
                  </div>
                  <div className="value-info">
                    <h4>Dealership</h4>
                    <p>Obcaecati adipisci vero dolorum pariatur</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="welcome-note">
            <h4 className="text-center color-grey">
              What Our Happy Clients say about us
            </h4>
            <h1 className="section-title-bg text-center">
              Customer Testimonial!
            </h1>
            <div className="mt-15">
              <div className="hr hr_primary hr_150"></div>
              <div className="hr hr_danger hr_200 mt-2"></div>
            </div>
          </div>
          <div className="mt-20">
            <div className="row">
              <div className="col-sm-3">
                <div className="testimonial">
                  <div className="bg-image"></div>
                  <div className="profile-image"></div>
                  <div className="title">
                    <h1 className="text-center">Alice Williams</h1>
                    <p className="text-center">Auto Dealer</p>
                  </div>
                  <div className="textimonial-text">
                    <p className="text-center">
                      It was popularised in the 1960s with the release of
                      Letraset sheets containing Lorem Ipsum passages, and more
                      recently with desktop publishing software.
                    </p>
                    <div className="mt-50 quote">
                      <i class="fa fa-quote-right icon" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="testimonial">
                  <div className="bg-image"></div>
                  <div className="profile-image"></div>
                  <div className="title">
                    <h1 className="text-center">Micheal Bean</h1>
                    <p className="text-center">Car Dealer</p>
                  </div>
                  <div className="textimonial-text">
                    <p className="text-center">
                      It was popularised in the 1960s with the release of
                      Letraset sheets containing Lorem Ipsum passages, and more
                      recently with desktop publishing software.
                    </p>
                    <div className="mt-50 quote">
                      <i class="fa fa-quote-right icon" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="testimonial">
                  <div className="bg-image"></div>
                  <div className="profile-image"></div>
                  <div className="title">
                    <h1 className="text-center">Felica Queen</h1>
                    <p className="text-center">Auto Dealer</p>
                  </div>
                  <div className="textimonial-text">
                    <p className="text-center">
                      It was popularised in the 1960s with the release of
                      Letraset sheets containing Lorem Ipsum passages, and more
                      recently with desktop publishing software.
                    </p>
                    <div className="mt-50 quote">
                      <i class="fa fa-quote-right icon" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-sm-3">
                <div className="testimonial">
                  <div className="bg-image"></div>
                  <div className="profile-image"></div>
                  <div className="title">
                    <h1 className="text-center">Felica Queen</h1>
                    <p className="text-center">Auto Dealer</p>
                  </div>
                  <div className="textimonial-text">
                    <p className="text-center">
                      It was popularised in the 1960s with the release of
                      Letraset sheets containing Lorem Ipsum passages, and more
                      recently with desktop publishing software.
                    </p>
                    <div className="mt-50 quote">
                      <i class="fa fa-quote-right icon" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="indicator">
            <div className="indicator primary-indicator"></div>
            <div className="indicator"></div>
            <div className="indicator"></div>
            <div className="indicator"></div>
          </div>
        </section>
        <Footer />
      </section>
    </>
  );
};

export default page;
