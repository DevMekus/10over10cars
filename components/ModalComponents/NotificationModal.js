"use client";
import React from "react";
import { useState } from "react";
import Pagination from "../Pagination";

const NotificationModal = () => {
  const [newNotice, setNewNotice] = useState(false);
  const [editNotice, setEditNotice] = useState(false);
  const [displayNotice, setDisplayNotice] = useState(true);

  const setNewNote = () => {
    setEditNotice(false);
    setNewNotice(true);
  };

  const editPost = (id) => {
    setNewNotice(false);
    setEditNotice(true);
  };

  const closeNew = () => {
    setNewNotice(false);
    setEditNotice(false);
  };

  return (
    <>
      <div className="wrapper">
        <p className="color-grey moveup-10">
          To create a new notification, click on the button below
        </p>
        <button
          type="button"
          className="button button-primary  radius-5"
          onClick={setNewNote}
        >
          <i className="fas fa-plus mr-10"></i>New
        </button>
        {newNotice && (
          <div className="mt-10 new-notice f-width">
            <div className="alert-header">
              <div>
                <h5 className="color-white">New Notification</h5>
                <p className="color-grey moveup-10s small-p">
                  Add a new notification.
                </p>
              </div>
              <button type="button" className="btn btn-sm" onClick={closeNew}>
                <i className="fas fa-times color-red mr-10"></i>
                <span className="color-grey">Close</span>
              </button>
            </div>

            <div className="mt-10">
              <div className="ctr-wrapper col-sm-4">
                <label className="color-grey">Title</label>
                <input
                  className="form-input form-ctr ctr-no-bg"
                  type="text"
                  placeholder="Ex: System upgrade"
                  required
                />
              </div>
              <div className="f-width">
                <textarea
                  rows={3}
                  className="form-input form-ctr ctr-no-bg"
                  placeholder="Write your message here"
                ></textarea>
              </div>
              <button type="button" className="button button-primary  radius-5">
                Save
              </button>
            </div>
          </div>
        )}

        {editNotice && (
          <div className="mt-10 new-notice f-width">
            <div className="alert-header">
              <div>
                <h5 className="color-white">Update Notification</h5>
                <p className="color-grey moveup-10s small-p">
                  Updating an existing notification: (
                  <span className="color-green">#782JHH</span>).
                </p>
              </div>
              <button type="button" className="btn btn-sm" onClick={closeNew}>
                <i className="fas fa-times color-red mr-10"></i>
                <span className="color-grey">Close</span>
              </button>
            </div>

            <div className="mt-10">
              <div className="ctr-wrapper col-sm-4">
                <label className="color-grey">Title</label>
                <input
                  className="form-input form-ctr ctr-no-bg"
                  type="text"
                  placeholder="Ex: System upgrade"
                  value="System upgrade"
                  required
                />
              </div>
              <div className="f-width">
                <textarea
                  rows={3}
                  className="form-input form-ctr ctr-no-bg"
                  placeholder="Write your message here"
                >
                  Google Fonts makes it easy to bring personality and
                  performance to your websites and products.
                </textarea>
              </div>
              <button type="button" className="button button-primary  radius-5">
                Save changes
              </button>
            </div>
          </div>
        )}
        <div className="container mt-10">
          <div className="n-modal-container scrollable">
            <h4 className="color-grey">Active notifications!</h4>
            <div className="mt-10 padding-10 special-bg">
              <div className="alert-header">
                <div>
                  <h5 className="color-white">System Upgrade</h5>
                  <p className="color-grey moveup-10s small-p">July 12, 2012</p>
                </div>
                <div>
                  <button
                    type="button"
                    className="btn btn-sm"
                    onClick={() => editPost()}
                  >
                    <i className="fas fa-edit color-green"></i>
                  </button>
                  <button type="button" className="btn btn-sm">
                    <i className="fas fa-times color-red"></i>
                  </button>
                </div>
              </div>
              <p className="color-white small-p">
                Google Fonts makes it easy to bring personality and performance
                to your websites and products.
              </p>
            </div>
            <div className="mt-10 f-width flex flex-end">
              <Pagination />
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default NotificationModal;
