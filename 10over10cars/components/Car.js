import Link from "next/link";
import React from "react";

const Car = ({ data }) => {
  return (
    <>
      <div className="car-box">
        <div
          className="car-image"
          style={{
            backgroundImage: `url(${data.imageUrl})`,
          }}
        >
          <div className="more-info">
            <Link
              href="/admin/vehicle/gallery/buy/id"
              className="no-decoration"
            >
              <span
                class="material-symbols-outlined color-primary"
                title="More Information"
              >
                sort
              </span>
            </Link>
          </div>
        </div>
        <div className="car-info mt-10">
          <div className="text-center star-rating">
            <i className="fas fa-star color-grey"></i>
            <i className="fas fa-star color-grey"></i>
            <i className="fas fa-star color-grey"></i>
            <i className="fas fa-star color-grey"></i>
          </div>
          <h5 className="text-center color-primary">{data.carName}</h5>
          <div>
            <div className="info align-center">
              <div className="flex flex-end">
                <p className="color-white ">${data.discountPrice}</p>
              </div>
              <div className="flex flex-start">
                {/* <p className="color-grey strike-through">${data.price}</p> */}
                <button className="button button-primary radius-5">
                  <i className="fas fa-shopping-cart mr-10"></i>Buy
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Car;
