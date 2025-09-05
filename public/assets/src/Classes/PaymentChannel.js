import { CONFIG } from "../Utils/config";
import { fetchEncryptionKey } from "../Utils/Session";
import PaystackPayment from "./Paystack";
import Utility from "./Utility";
import { DataTransfer } from "../Utils/api";
/**
 * PaymentChannel.js
 *
 * Handles payments through Paystack.
 * Integrates with Utility, Session, and API helpers for
 * a complete verification payment flow.
 *
 * Dependencies:
 *  - CONFIG: Global configuration values.
 *  - fetchEncryptionKey: Retrieves encryption keys for secure transactions.
 *  - PaystackPayment: Wrapper for Paystack SDK integration.
 *  - Utility: Provides UI helpers (confirmation, toasts, etc.).
 *  - DataTransfer: Handles API communication.
 */

export default class PaymentChannel {
  /**
   * Initiates Paystack payment flow for verification services.
   *
   * @param {Object} paymentData - Details required for the payment.
   * @param {string} paymentData.vin - Vehicle Identification Number.
   * @param {string} paymentData.email_address - Payer email.
   * @param {string} paymentData.fullname - Payer full name.
   * @param {number} paymentData.amount - Payment amount (in Naira).
   * @param {string} [paymentData.plan] - Plan type.
   *
   * @returns {Promise<void>}
   */
  static async payWithPaystack(paymentData) {
    try {
      if (
        !paymentData?.vin ||
        !paymentData?.email_address ||
        !paymentData?.amount
      ) {
        Utility.toast("Invalid payment data. Please try again.", "error");
        return;
      }

      // Ask user to confirm payment
      const result = await Utility.confirm(
        "Verification Payment",
        `You are paying to verify ${paymentData.vin}`
      );

      if (!result?.isConfirmed) {
        return; // User cancelled
      }

      Swal.close();

      // Retrieve payment encryption key
      const getKey = await fetchEncryptionKey();
      if (!getKey?.success || !getKey.PAYSTACK_PK) {
        Utility.toast("Unable to fetch payment key. Try again later.", "error");
        return;
      }

      Utility.toast("Please wait...", "info");

      // Initialize Paystack payment
      const paystack = new PaystackPayment({
        publicKey: getKey.PAYSTACK_PK,
      });

      paystack.pay({
        email: paymentData.email_address,
        amount: Number(paymentData.amount), // in Naira
        metadata: {
          custom_fields: [
            { display_name: "Name", value: paymentData.fullname ?? "Unknown" },
            { display_name: "Email", value: paymentData.email_address },
            { display_name: "Amount", value: paymentData.amount },
          ],
        },

        /**
         * Handle successful payment.
         * @param {Object} response - Paystack response object.
         */
        onSuccess: async function (response) {
          try {
            const data = {
              reference: response.reference,
              userid: "",
              email_address: paymentData.email_address,
              plan: paymentData.plan ?? "default",
              vin: paymentData.vin,
            };

            const httpRes = await DataTransfer(
              `${CONFIG.API}/payment/verify`,
              data,
              "POST"
            );

            Swal.fire(
              httpRes?.status === 200 ? "Success!" : "Error",
              httpRes?.message ?? "Payment verification failed.",
              httpRes?.status === 200 ? "success" : "error"
            );
          } catch (err) {
            console.error("Error verifying payment:", err);
            Swal.fire("Error", "Payment verification failed.", "error");
          }
        },

        /**
         * Handle payment cancellation/closure.
         */
        onClose: function () {
          Swal.fire("Error", "Payment window closed.", "error");
        },
      });
    } catch (error) {
      console.error("Error during Paystack payment flow:", error);
      Utility.toast("An unexpected error occurred. Try again later.", "error");
    }
  }
}
