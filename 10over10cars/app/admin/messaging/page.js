"use client";
import React from "react";
import Link from "next/link";
import Modal from "@/components/Modal";
import { useState } from "react";

import NotificationModal from "@/components/ModalComponents/NotificationModal";

const page = () => {
  const [notification, setNotification] = useState(false);

  function newNotification(event) {
    event.preventDefault();
    alert("Posting a new Notification");
  }

  function modalClose() {
    setNotification(false);
  }
  return (
    <>
      {notification && (
        <Modal
          modalTitle="Notification Manager"
          Component={NotificationModal}
          modalAction={newNotification}
          modalClose={modalClose}
          size="modal-md"
        />
      )}
      <div className="dash-page">
        <div className="card-primary">
          <h4 class="color-primary">Messaging & Alert Management</h4>
          <p className="color-grey">
            Manage all the accounts alert, information and messaging including
            Support, Blog posts and notifications.
          </p>
        </div>
        <div className="mt-20">
          <h5 className="color-white">Support Management</h5>
          <p className="color-grey">
            Manage all the reports of stolen cars in this section.
          </p>
          <div className="moveup-10">
            <Link href="/admin/messaging/support" className="link decoration">
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>
                Support manager
              </p>
            </Link>
          </div>
        </div>
        <div className="mt-20 special-bg padding-10">
          <h5 className="color-white">Notifications & Alert</h5>
          <p className="color-grey">
            Manage all the reports of stolen cars in this section.
          </p>
          <div className="moveup-10">
            <Link
              href="#"
              className="link decoration"
              onClick={() => {
                setNotification(true);
              }}
            >
              <p className="color-grey">
                <i className="fas fa-arrow-right mr-10 color-primary"></i>
                Alert Manager
              </p>
            </Link>
          </div>
        </div>
       
      </div>
    </>
  );
};

export default page;
