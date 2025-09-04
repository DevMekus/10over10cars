import { CONFIG } from "../Utils/config";
import { fetchEncryptionKey } from "../Utils/Session";
import PaystackPayment from "./Paystack";
import Utility from "./Utility";
import { DataTransfer } from "../Utils/api";

export default class PaymentChannel {
  static async payWithPaystack(paymentData) {
    try {
      const result = await Utility.confirm(
        "Verification Payment",
        `You are paying to verify ${paymentData.vin}`
      );

      if (result.isConfirmed) {
        Swal.close();

        //--Get payment key

        const getKey = await fetchEncryptionKey();
        if (!getKey.success) {
          Utility.toast("An error has occurred. Try again later", "error");
          return;
        }

        Utility.toast("Please wait...", "info");

        const paystack = new PaystackPayment({
          publicKey: getKey.PAYSTACK_PK,
        });

        paystack.pay({
          email: paymentData.email_address,
          amount: Number(paymentData.amount), // in Naira
          metadata: {
            custom_fields: [
              { display_name: "Name", value: paymentData.fullname },
              { display_name: "Email", value: paymentData.email_address },
              { display_name: "Amount", value: paymentData.amount },
            ],
          },

          onSuccess: async function (response) {
            const data = {
              reference: response.reference,
              userid: "",
              email_address: paymentData.email_address,
              plan: paymentData.plan,
              vin: paymentData.vin,
            };

            const httpRes = await DataTransfer(
              `${CONFIG.API}/payment/verify`,
              data,
              "POST"
            );

            Swal.fire(
              httpRes.status == 200 ? "Success!" : "Error",
              `${httpRes.message}`,
              httpRes.status == 200 ? "success" : "error"
            );
          },
          onClose: function () {
            Swal.fire("Error", `Payment window closed.`, "error");
          },
        });
      }
    } catch (error) {
      console.error(error);
    }
  }
}
