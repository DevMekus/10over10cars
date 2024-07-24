import React from "react";

const Blog = () => {
  return (
    <>
      <div>
        <div className="blog-wrapper">
          <div
            className="image-wrapper"
            style={{
              backgroundImage: `url(https://themes.potenzaglobalsolutions.com/react/car-dealer/static/media/blog-img1.6a781a0ef630d6cba5c4.webp)`,
            }}
          >
            <div className="date-wrap bg-red">
              <span>24</span>
              <span>Jan</span>
            </div>
          </div>
          <div className="blog-info">
            <p className="blog-type">AUTO DEALER</p>

            <div className="mt-10s">
              <h3 className="color-yellow">
                Seven Must Have Feature of a Modern Car
              </h3>
              <div className="read">
                <p className="flex gap-10 align-center">
                  <span className="bold">Read more</span>
                  <span className="blog-arrow">
                    {" "}
                    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Blog;
