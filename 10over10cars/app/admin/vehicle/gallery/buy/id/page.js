import React from "react";

const page = () => {
  return (
    <>
      <div className="dash-page mt-20">
        <div className="container">
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
                  <i className="fas fa-shopping-cart mr-10"></i>Add to cart
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
        </div>
      </div>
    </>
  );
};

export default page;
