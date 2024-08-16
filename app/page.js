import React from "react";
import Link from "next/link";
import HeroSection from "@/components/HeroSection";
import carData from "@/library/carData";
import Car from "@/components/Car";
import Blog from "@/components/Blog";
import Footer from "@/components/Footer";

const page = () => {
  return (
    <>
      <section className="page-wrapper">
        <HeroSection />
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-6">
              <h1 className="section-title-bg">
                We Provides Best Solution for Vehicles verification
              </h1>
              <div className="flex gap-20 mbb-5">
                <div className="icon-wrap icon-wrap-primary">
                  <span className="material-symbols-outlined">task_alt</span>
                </div>
                <p>Free VIN Check</p>
              </div>
              <div className="flex gap-20 mbb-5">
                <div className="icon-wrap icon-wrap-primary">
                  <span className="material-symbols-outlined">task_alt</span>
                </div>
                <p>Vehicle Search</p>
              </div>
              <div className="flex gap-20">
                <div className="icon-wrap icon-wrap-primary">
                  <span className="material-symbols-outlined">task_alt</span>
                </div>
                <p>Vehicle history report</p>
              </div>
              <button className="button button-primary radius-5 mt-10">
                Get started
              </button>
            </div>
            <div className="col-sm-6">
              <p>
                ver 10 quisque sodales dui ut varius vestibulum drana tortor
                turpis porttiton tellus eu euismod nisl massa nutodio in the
                miss volume place urna lacinia eros nunta urna mauris vehicula
                rutrum in the miss on volume interdum.
              </p>
              <p>
                ver 10 quisque sodales dui ut varius vestibulum drana tortor
                turpis porttiton tellus eu euismod nisl massa nutodio in the
                miss volume place urna lacinia eros nunta urna mauris vehicula
                rutrum in the miss on volume interdum.
              </p>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          {" "}
          <h1 className="section-title-bg">
            Services you can
            <br /> count on!
          </h1>
          <div className="row">
            <div className="col-sm-3">
              <div className="flex flex-center">
                <div className="iconBox flex-center">
                  <img
                    src="https://cdn1.iconfinder.com/data/icons/general-insurance-protection/378/general-insurance-003-256.png"
                    className="img-fluid"
                    alt="service-image"
                  />
                </div>
              </div>
              <div className="service">
                <h4 className="service-title text-center">
                  Theft verification
                </h4>
                <p className="text-center">
                  The VIN is the only thing you need to know. Your 17-digit VIN
                  can be found in car documents.
                </p>
              </div>
            </div>
            <div className="col-sm-3">
              <div className="flex flex-center">
                <div className="iconBox">
                  <img
                    src="https://cdn2.iconfinder.com/data/icons/xomo-basics/128/documents-01-256.png"
                    className="img-fluid"
                    alt="service-image"
                  />
                </div>
              </div>
              <div className="service">
                <h4 className="service-title text-center">History Report</h4>
                <p className="text-center">
                  The VIN is the only thing you need to know. Your 17-digit VIN
                  can be found in car documents.
                </p>
              </div>
            </div>
            <div className="col-sm-3">
              <div className="flex flex-center">
                <div className="iconBox">
                  <img
                    src="https://cdn1.iconfinder.com/data/icons/data-science-flat-1/64/data-analysis-inspection-zoom-information-science-256.png"
                    className="img-fluid"
                    alt="service-image"
                  />
                </div>
              </div>

              <div className="service">
                <h4 className="service-title text-center">
                  Pre-purchase Inspection
                </h4>
                <p className="text-center">
                  The VIN is the only thing you need to know. Your 17-digit VIN
                  can be found in car documents.
                </p>
              </div>
            </div>
            <div className="col-sm-3">
              <div className="flex flex-center">
                <div className="iconBox">
                  <img
                    src="https://cdn4.iconfinder.com/data/icons/car-maintenance-and-service/32/luxury-sports-car-auction-premium-buy-256.png"
                    className="img-fluid"
                    alt="service-image"
                  />
                </div>
              </div>
              <div className="service">
                <h4 className="service-title text-center">Car MarketPlace</h4>
                <p className="text-center">
                  The VIN is the only thing you need to know. Your 17-digit VIN
                  can be found in car documents.
                </p>
              </div>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-6">
              <div className="row">
                <div className="col-sm-4">
                  <div className="brandImage">
                    <img
                      src="https://images-platform.99static.com//fQPg292-TDSkmpYm7NPEetUidyI=/420x0:1501x1080/fit-in/500x500/99designs-contests-attachments/64/64280/attachment_64280401"
                      alt="Picture of the author"
                      className="img-fluid"
                    />
                  </div>
                </div>
                <div className="col-sm-4">
                  <div className="brandImage">
                    <img
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsGQjqxTjp6zGYc6zJVIwx6jtgqdlIDrXU72AFfUPmCn96wKUOqPXeGBiJiAkiv0kmNJY&usqp=CAU"
                      alt="Picture of the author"
                      className="img-fluid"
                    />
                  </div>
                </div>
                <div className="col-sm-4">
                  <div className="brandImage">
                    <img
                      src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGinpQYnrglx8juZtkk4F4i1eynaJa5Gn1UCLMUs7RXcn4EnpqHcqDlQtSwuC-BZqR7sQ&usqp=CAU"
                      alt="Picture of the author"
                      className="img-fluid"
                    />
                  </div>
                </div>
              </div>
              <div className="mt-15">
                <div className="row">
                  <div className="col-sm-4">
                    <div className="brandImage">
                      <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSgD58Wgmqo4pV-n20UkQZ8cLKG_E6ONKAUtphF4kuuHWZyWubZngVHX0byDi59tgIHW-0&usqp=CAU"
                        alt="Picture of the author"
                        className="img-fluid"
                      />
                    </div>
                  </div>
                  <div className="col-sm-4">
                    <div className="brandImage">
                      <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScXxoIiO-Kz2931YKLOETfqjt9tez7Ix15UnmcI0cPOaxYXz5LnZAw4i6WniUOsAPraw0&usqp=CAU"
                        alt="Picture of the author"
                        className="img-fluid"
                      />
                    </div>
                  </div>
                  <div className="col-sm-4">
                    <div className="brandImage">
                      <img
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGinpQYnrglx8juZtkk4F4i1eynaJa5Gn1UCLMUs7RXcn4EnpqHcqDlQtSwuC-BZqR7sQ&usqp=CAU"
                        alt="Picture of the author"
                        className="img-fluid"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="col-sm-6">
              <h1 className="section-title-bg">
                We have all the
                <br /> <span className="color-primary">support</span> We need!
              </h1>

              <p className="text-centers color-whites">
                Our system is secure and reliable, thanks to these amazing
                brands
              </p>
              <p className="color-whites">
                Lorem Ipsum has been the industry's standard dummy text ever
                since the 1500s, when an unknown printer took a galley of type
                and scrambled it to make a type
              </p>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <h1 className="section-title-bg">
            We have the
            <br /> <span className="color-primary">best cars</span> for sale
            too!
          </h1>
          <p>
            10over10 Cars is the most enticing, creative, modern and
            multipurpose auto dealer and verification platform.
          </p>
          <div className="mt-15">
            <div className="row">
              {carData.map((cars) => (
                <div className="col-sm-3 mb-10" key={cars.id}>
                  <Car data={cars} />
                </div>
              ))}
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-6">
              <div className="service-into-image">
                <div className="floating-div">
                  <h5 className="section-title-bg">
                    The best
                    <br /> and <span className="color-primary">affordable</span>
                    <br />
                    services
                  </h5>
                </div>
              </div>
            </div>
            <div className="col-sm-6">
              <div className="ml-100">
                <h1 className="main-title">
                  We Provides Best Solution Vehicles
                </h1>
                <p className="mt-15">
                  Car Dealer is the most enticing, creative, modern and
                  multipurpose auto dealer Premium WordPress Theme. Suitable for
                  any car dealer websites, business or corporate websites.
                </p>
                <div className="mt-15 why-best">
                  <p>
                    <i className="fas fa-check mr-10 color-yellow"></i>
                    What maintenance does an electric car need?{" "}
                  </p>
                  <p>
                    <i className="fas fa-check mr-10 color-yellow"></i>
                    Analyse each tyre for any excess tread wear.
                  </p>
                  <p>
                    <i className="fas fa-check mr-10 color-yellow"></i> Access
                    control put an electric vehicle charge.
                  </p>
                  <p>
                    <i className="fas fa-check mr-10 color-yellow"></i>
                    Each tyre for any excess tread wear.
                  </p>
                </div>
                <div className="mt-15 flex gap-30 align-center">
                  <div className="default-btn  bg-red color-white">
                    Our service
                  </div>
                  <div className="icon-wrap wrap-primary">
                    <span className="material-symbols-outlined">
                      phone_in_talk
                    </span>
                  </div>
                  <p>
                    <span>Call us @</span>
                    <br />
                    <span className="bold">+23727367283</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section className="cta container section-padding">
          <div className="cta-inner">
            <h1 className="section-title-bg color-grey">
              Verify your
              <br /> vehicle History
              <br /> and <span className="color-primary">Save BIG</span>
            </h1>
            <div className="btn-play ">
              <span className="material-symbols-outlined">play_arrow</span>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="brand-progress">
            <div className="container">
              <div className="row">
                <div className="col-sm-3">
                  <h1>400k</h1>
                  <h3>Vehicles</h3>
                </div>
                <div className="col-sm-3">
                  <h1>20+</h1>
                  <h3>Experience</h3>
                </div>
                <div className="col-sm-3">
                  <h1>205+</h1>
                  <h3>Satisfied Customers</h3>
                </div>
                <div className="col-sm-3">
                  <h1>30+</h1>
                  <h3>Car Dealers</h3>
                </div>
              </div>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <div className="row">
            <div className="col-sm-6">
              <h1 className="section-title-bg">
                Download Our{" "}
                <span className="color-primary">Verification Application</span>.
              </h1>
              <p>
                Car Dealer is the most enticing, creative, modern and
                multipurpose auto dealer Premium WordPress Theme. Suitable for
                any car dealer websites, business or corporate websites.
              </p>
              <div className="mt-15">
                <p>
                  <i className="fas fa-check mr-10 color-yellow"></i>
                  What maintenance does an electric car need?{" "}
                </p>
                <p>
                  <i className="fas fa-check mr-10 color-yellow"></i>
                  Analyse each tyre for any excess tread wear.
                </p>
                <p>
                  <i className="fas fa-check mr-10 color-yellow"></i> Access
                  control put an electric vehicle charge.
                </p>
                <p>
                  <i className="fas fa-check mr-10 color-yellow"></i>
                  Each tyre for any excess tread wear.
                </p>
              </div>
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
            <div className="col-sm-6">
              <div
                className="app-download-img"
                style={{
                  backgroundImage: `url(https://images.unsplash.com/photo-1597075095400-fb3f0de70140?q=80&w=1889&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D)`,
                }}
              ></div>
            </div>
          </div>
        </section>
        <section className="container section-padding">
          <h1 className="section-title-bg">
            Recent News <br />& <span className="color-green">Articles</span>
          </h1>
          <p>
            Car Dealer is the most enticing, creative, modern and multipurpose
            auto dealer Premium WordPress Theme.
          </p>
          <div className="row">
            <div className="col-sm-4">
              <Blog />
            </div>
            <div className="col-sm-4">
              {" "}
              <Blog />
            </div>
            <div className="col-sm-4">
              {" "}
              <Blog />
            </div>
          </div>
        </section>
        <Footer />
      </section>
    </>
  );
};

export default page;
