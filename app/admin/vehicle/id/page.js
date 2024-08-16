import React from "react";
import CarInfoFlex from "@/components/CarInfoFlex";
import SalesSummaryFlex from "@/components/SalesSummaryFlex";

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
      <div className="dash-page mt-20">
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
                <button className="button button-primary radius-5">
                  <i className="fas fa-download mr-10"></i>Download PDF
                </button>
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
          <div className="row">
            <div className="col-sm-8">
              <div className="row">
                <div className="col-sm-6">
                  <div className="verification-info">
                    <h4 className="color-grey">Verification Summary</h4>
                    <div className="mt-10">
                      <CarInfoFlex items={summary} />
                    </div>
                  </div>
                </div>
                <div className="col-sm-6">
                  <div className="verification-info">
                    <h4 className="color-grey">Car Information</h4>
                    <div className="mt-10">
                      <CarInfoFlex items={carInfo} />
                    </div>
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="special-bg padding-20">
                  <h4 className="color-grey">Ownership History</h4>
                  <p className="color-grey moveup-10">7 records found</p>
                  <div className="col-sm-5">
                    <h4 className="color-white">Johnson Peace</h4>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">Miles driven per year</p>
                      <p className="color-grey">4,469ml</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">Odometer reading</p>
                      <p className="color-grey">4,469ml</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">Purchased in</p>
                      <p className="color-grey">2008</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">Est. length of use</p>
                      <p className="color-grey">0years. 7months</p>
                    </div>
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="special-bg padding-20">
                  <h4 className="color-grey">Odometer check</h4>
                  <p className="color-grey moveup-10">4 records found</p>
                  <div className="col-sm-6">
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">Tampering check</p>
                      <p className="color-grey">No problem found</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">Replaced</p>
                      <p className="color-grey">Yes</p>
                    </div>
                    <div className="f-width flex space-between align-center">
                      <p className="bold color-white">
                        Reading at time of renewal
                      </p>
                      <p className="color-grey">4,469ml</p>
                    </div>
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="special-bg padding-20">
                  <h4 className="color-grey">System's check</h4>
                  <p className="color-grey moveup-10">2 records found</p>
                  <div>
                    <ul>
                      <li>
                        <h5 className="color-white">Equipments: Electrical</h5>
                        <p className="color-grey moveup-10">July 10, 2023</p>
                      </li>
                    </ul>

                    <p className="color-white">
                      BMW of North America, LLC (BMW) is recalling certain 2018
                      BMW 330e iPerformance, i3 Rex, i3 Sport Rex, X5 xDrive40e,
                      i3 BEV, i3 Sport BEV and 2019 i8 and i8 Roadster vehicles
                      and 2018-2019 530e iPerformance
                    </p>
                  </div>
                  <div>
                    <ul>
                      <li>
                        <h5 className="color-white">Fuel System: Fuel tank</h5>
                        <p className="color-grey moveup-10">July 10, 2023</p>
                      </li>
                    </ul>
                    <p className="color-white">
                      BMW of North America, LLC (BMW) is recalling certain 2018
                      BMW 330e iPerformance, i3 Rex, i3 Sport Rex, X5 xDrive40e,
                      i3 BEV, i3 Sport BEV and 2019 i8 and i8 Roadster vehicles
                      and 2018-2019 530e iPerformance
                    </p>
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="special-bg padding-20">
                  <h4 className="color-grey">Theft check</h4>
                  <p className="color-grey moveup-10">No records found</p>
                </div>
              </div>
              <div className="mt-10">
                <div className="special-bg padding-20">
                  <h4 className="color-grey">Sales History</h4>
                  <p className="color-grey moveup-10">3 records found</p>
                  <div className="row">
                    {salesHistory.map((items, i) => (
                      <div className="col-sm-6" key={i}>
                        <SalesSummaryFlex items={items} />
                      </div>
                    ))}
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="special-bg padding-20">
                  <h4 className="color-grey">Market Analysis</h4>
                  <p className="color-grey moveup-10">1 record found</p>
                  <p className="color-white">
                    Market price analysis is based on a vehicle's history such
                    as vehicle class and age, number of owners, accident and
                    damage history, title brands, odometer readings, etc. This
                    information is used to compare the vehicle's favorability
                    against the entire market of vehicles with
                  </p>
                </div>
              </div>
            </div>
            <div className="col-sm-4">
              <h4 className="color-grey">Vehicle images</h4>
              <div className="mt-10">
                <div className="col-sm-12">
                  <div>
                    <img
                      src="/hero-image.webp"
                      className="img-fluid"
                      alt="hero-image"
                    />
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="col-sm-12">
                  <div>
                    <img
                      src="/hero-image.webp"
                      className="img-fluid"
                      alt="hero-image"
                    />
                  </div>
                </div>
              </div>
              <div className="mt-10">
                <div className="col-sm-12">
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
        </section>
      </div>
    </>
  );
};

export default page;
