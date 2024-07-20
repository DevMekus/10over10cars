import React from "react";
import carData from "@/library/carData";
import Car from "@/components/Car";

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
          <div>
            <div className="row">
              <div className="col-sm-3">
                <h4 className="color-grey">Purchase filters</h4>
                <div className="mt-10 special-bg padding-10">
                  <div className="col-sm-12">
                    <label className="color-grey">Search</label>
                    <input
                      className="form-input form-ctr ctr-no-bg"
                      type="text"
                      placeholder="Ex: Toyota, X4"
                      required
                    />
                  </div>
                  <div className="col-sm-12">
                    <label className="color-grey">Select filter</label>
                    <select className="form-input form-ctr ctr-no-bg">
                      <option>X5</option>
                      <option>Sedan</option>
                      <option>Lexus</option>
                      <option>Avalon</option>
                    </select>
                  </div>
                </div>
              </div>
              <div className="col-sm-9">
                <div className="f-width flex flex-end align-center">
                  <button className="btn btn-light btn-sm">
                    <span class="material-symbols-outlined">sort</span>
                  </button>
                </div>
                <div className="mt-10 padding-20 car-list">
                  <div className="row">
                    {carData.map((cars) => (
                      <div className="col-sm-4" key={cars.id}>
                        <Car data={cars} />
                      </div>
                    ))}
                  </div>
                  <div className="f-width flex flex-end">
                    <nav aria-label="...">
                      <ul class="pagination">
                        <li class="page-item disabled">
                          <a class="page-link">Previous</a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">
                            1
                          </a>
                        </li>
                        <li class="page-item active" aria-current="page">
                          <a class="page-link" href="#">
                            2
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">
                            3
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">
                            Next
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default page;
