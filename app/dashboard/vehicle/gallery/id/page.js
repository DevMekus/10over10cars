import React from "react";
import CarInfoFlex from "@/components/CarInfoFlex";
import DashboardsFooter from "@/components/DashboardsFooter";
import CarVerification from "@/components/CarVerification";

const page = () => {
  const carInfo = {
    "Vehicle name": "Avalon",
    "Vehicle Year": 2002,
    Make: "Totota",
    Model: "X5",
    Engine: "3L",
    Transmission: "Automatic",
    "Made in": "United States",
  };

  const summary = {
    Odometer: `No problem found`,
    Accidents: "3 problems found",
    "System checks": "No problem found",
    Owners: "6 records found",
    Mileage: "9,920",
  };
  const salesHistory = [
    {
      Date: "July 12, 1980",
      Location: "Accra, Ghana",
      Odometer: "2,607",
      Cost: "$61,796",
    },
    {
      Date: "October 09, 2001",
      Location: "Abuja, Nigeria",
      Odometer: "6,907",
      Cost: "$51,796",
    },
  ];

  return (
    <>
      <div className="dash-page">
        <section className="container">
          <div className="row">
            <div className="col-sm-4">
              <div className="vehicle-title">
                <h1 className="car-name">
                  <span className="car-name color-primary bold">
                    Toyota Avalon{" "}
                    <span>
                      <span class="material-symbols-outlined color-green">
                        task_alt
                      </span>
                    </span>
                  </span>
                  <br />
                  <span className="year color-grey">
                    {" "}
                    2010 <span className="model color-green">Skylight</span>
                  </span>
                </h1>
                <p className="color-grey">
                  This is a brief verification note about this particular car.
                </p>
                <div className="flex gap-10 align-center">
                  <button className="button button-primary radius-5">
                    <i className="fas fa-shopping-cart mr-10"></i>add to cart
                  </button>
                  <div>
                    <CarVerification />
                  </div>
                </div>
              </div>
            </div>
            <div className="col-sm-8">
              <div className="hero-image-container">
                <img
                  src="/hero-image.webp"
                  className="img-fluid"
                  alt="hero-image"
                />
              </div>
            </div>
          </div>
          <div className="mt-20">
            <div className="row">
              <div className="col-sm-4">
                <div className="row">
                  <div className="col-sm-6">
                    <div className="verification-info">
                      <h4 className="color-grey">Car Information</h4>
                      <div className="mt-10">
                        <CarInfoFlex items={carInfo} />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-sm-8">
                <h4 className="color-grey">Vehicle images</h4>
                <div className="row">
                  <div className="col-sm-6">
                    <div>
                      <img
                        src="/hero-image.webp"
                        className="img-fluid"
                        alt="hero-image"
                      />
                    </div>
                  </div>
                  <div className="col-sm-6">
                    <div>
                      <img
                        src="/hero-image.webp"
                        className="img-fluid"
                        alt="hero-image"
                      />
                    </div>
                  </div>
                </div>
                <div className="row">
                  <div className="col-sm-6">
                    <div>
                      <img
                        src="/hero-image.webp"
                        className="img-fluid"
                        alt="hero-image"
                      />
                    </div>
                  </div>
                  <div className="col-sm-6">
                    <div>
                      <img
                        src="/hero-image.webp"
                        className="img-fluid"
                        alt="hero-image"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
      <DashboardsFooter />
    </>
  );
};

export default page;
