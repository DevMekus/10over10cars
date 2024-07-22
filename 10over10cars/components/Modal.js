import React from "react";

const Modal = ({
  modalTitle,
  Component,
  modalAction,
  modalClose,
  size = null,
}) => {
  return (
    <>
      <div className="custom-modal custom-modal-fade">
        <div className={`custom-modal-dialog ${size}`}>
          <div className="custom-modal-content">
            <div className="c-modal-header">
              <h1 className="c-modal-title">{modalTitle}</h1>
              <button
                type="button"
                className="btn-close color-grey"
                data-dismiss="custom-modal"
                onClick={modalClose}
              ></button>
            </div>
            <div className="c-modal-body scrollable">
              <form onSubmit={modalAction}>
                <div className="wrapper">
                  <Component />
                </div>
              </form>
            </div>
            <div className="c-modal-footer"></div>
          </div>
        </div>
      </div>
    </>
  );
};

export default Modal;
